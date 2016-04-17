<?php namespace App\Http\Controllers;

use Session;
use App\Parking;
use App\ParkingField;
use App\ParkingLocation;
use App\Booking;
use App\Location;
use App\User;
use App\Configuration;
use App\ConfigurationGlobal;
use App\Field;
use App\Tag;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App;
use Auth;
use Request;
use Storage;
use App\Http\Requests\BookRequest;
use App\Http\Requests\AddParkingRequest;
use Input;
use Carbon;
use Validator;
use Image;
use Imagine;
use App\Product;
use Cookie;
use File;

use Ivory\GoogleMap\Helper\MapHelper;
use Illuminate\Support\Facades\Redirect;

use App\Commands\BookParking;

class ParkingsController extends Controller {

	/**
     * Instantiate a new ParkingsController instance.
     */
    public function __construct()
    {
        $this->middleware('auth.admin', ['except' => ['show', 'book', 'payment', 'setBookingPrice', 'checkout']]);
    }

	//public function index()
	public function all()
	{
		$parkings = Parking::all();

		return view('parkings.index', compact('parkings'));
	}

	public function show($id)
	//public function view($id)
	{
		//$allowedList = array_keys(Session::get('allowedParkings')) or App::abort(403, 'Unauthorized');

		// This is to check that only parkings returned from the query are accessed
		// E.g. if a user tries to visit a different parking by changing the URL then abort
		$is_admin = NULL;
		if (Auth::check()){
			$user = Auth::user();
			$is_admin = $user->is_admin;
		}

		$parking = Parking::findOrFail($id);
		$parking->price = Session::get('allowedParkings')[$parking->parking_id];

		// get the traslations of the current locale
		$translations = get_parking_translation( $id );

		Session::put('selectedParking', $id);

		$pcur = get_parking_currency($id);

		// create the google map
		$map = build_map( $parking->lat, $parking->lng, $parking->parking_name ); //uses helpers.php
		$mapHelper = new MapHelper();

		$images = glob('img/parkings/'.$id.'/thumb/*.{jpg,JPG,png,PNG}', GLOB_BRACE);
		$url = null;

		foreach($images as $img) {
			$url[] = basename($img);
		}

		return view('parkings.show', compact('parking', 'map', 'mapHelper', 'translations', 'pcur', 'url'));
	}

	public function book($id)
	{
		// Control this request
		//Session::put('bookingInProcess', $selectedParking);

		//Session::keep(['allowedParkings']);
		$allowed_pids = Session::get('allowedParkings');

		// if this array is empty then you shouldn't really be here
		if (empty($allowed_pids)) {
		    App::abort(403, 'Unauthorized');
		}

		// This is to check that only parkings returned from the query are accessed
		// E.g. if a user tries to visit a different parking by changing the URL then abort
		if (!array_key_exists($id, $allowed_pids)) {
		    App::abort(403, 'Unauthorized');
		}

		foreach($allowed_pids as $key => $value){
			$allowedList[] = $key;
		}

		foreach ($allowed_pids as $key => $value) {
			$selectedParking['parking_id'] = $id;
			$selectedParking['price'] = $allowed_pids[$id];
		}

		//parking details like name etc.
		$parking = Parking::find($id);
		Session::set('parkingName', $parking->parking_name);

		// Delete allowed parkings session array as we have already selected an $id
		// and set it again with the only allowed parking which was selected
		Session::forget('allowedParkings');
		$singleAllowedParking[$selectedParking['parking_id']] = $selectedParking['price'];
		Session::set('allowedParkings', $singleAllowedParking);

		//Mike
		if (is_numeric($parking->online_discount)) {
			$discount = $parking->online_discount;
		}
		else {
			$discount = 0;
		}
		$selectedParking['price_card'] = $selectedParking['price'] * (100 - $discount)/100;
		Session::put('selectedParking', $selectedParking);

		$discount_text = -1 * $discount;

		$fields = DB::select('CALL GetParkingFields( '.$id.' )');

		$user = Auth::user();

		// get the traslations of the current locale
		$translations = get_parking_translation( $id );

		$title_attributes = NULL;
		foreach ($translations as $key2 => $value2) {
			if ($key2 == 'title'){
				$title_attributes = $value2['attributes'];
				$translations['title'] = $value2['value'];
			} elseif ($key2 == 'passengers'){
				$passengers_attributes = $value2['attributes'];
				$translations['passengers'] = $value2['value'];
			}
		}

		$allPhoneCodes = DB::table('PHONE_CODE')->where('code', '!=', 'NONE')->orderBy('iso2')->get();

		$countries = NULL;
		foreach ($allPhoneCodes as $country) {
			$countries[] = ['country_id' => $country->country_id,
							'locale' => $country->iso2,
							'flag' => strtolower($country->iso2),
							'code' => '(00'.$country->code.')'];
		}

		$products = Product::where('parking_id', $parking->parking_id)->get();
		$prod_trans = get_product_translations( $parking->parking_id );

		$p_trans = null;
		if(!empty($prod_trans)){
			foreach ($prod_trans as $value) {
				$p_trans[$value->product_id] = ['name' => $value->name, 'description' => $value->description];
			}
		}

		$payment_methods = explode(',', $parking->payment_methods);

		// reset the session in case of any selected products that have left in the session
		Session::forget('selectedProducts');

		// temporarily store this to be used in the unlocalized payment page
		Session::put('locale_tmp', App::getLocale());

		return view('parkings.book', compact('fields', 'countries', 'id', 'user', 'translations', 'p_trans', 'parking', 'title_attributes', 'passengers_attributes', 'products', 'payment_methods', 'discount_text'));
	}

	// using Ajax
	public function setBookingPrice()
	{
		if(Request::ajax()){
			/*$response = Response::json(Request::all());
			$json = json_decode($response, true);
			var_dump(Request::all());*/

			$data = Request::all();

			// set a session with the selected Products
			Session::forget('selectedProducts');

			if (array_key_exists('productIDs', $data))
				Session::set('selectedProducts', $data['productIDs']);

			/*$selectedArray = Session::get('selectedParking');
			$selectedArray['price'] = $data['totalPrice'];
			Session::set('selectedParking', $selectedArray);*/

			$selectedArray = Session::get('selectedParking');
			$selectedArray['productsPrice'] = $data['productsPrice'];

			if (array_key_exists('productIDs', $data)){
				$selectedArray['selectedProducts'] = $data['productIDs'];
			} else {
				$selectedArray['selectedProducts'] = 0;
			}

			Session::set('selectedParking', $selectedArray);

			$sessions = Session::get('selectedParking');

			return ($sessions);
		}

		return null;
	}

	public function payment(BookRequest $request)
	{
<<<<<<< HEAD
		//Session::forget('bookingInProcess');

		$input = $request->all();

		$selectedArray = Session::get('selectedParking');
		Session::forget('selectedParking');

		$selectedId = $selectedArray['parking_id'];
		$selectedPrice = $selectedArray['price'];

		if (array_key_exists('productsPrice', $selectedArray))
			$selectedProductsPrice = $selectedArray['productsPrice'];
		else
			$selectedProductsPrice = 0;

		$data = Session::all();

		$mode = 'L'; // set the mode for GetResults to (L)ive
		if (Auth::check()){
			if (Auth::user()->debug == 'Y')
				$mode = 'T'; // only set to (T)est if the debug setting is turned on for the particular logged in User
		}
		// Final check of Availability
		$lang = Session::get('applocale');
		$avail_parks = DB::select('CALL GetResults('.$data['location'].', "'.$data['checkindate'].'", "'.$data['checkintime'].'", "'.$data['checkoutdate'].'", "'.$data['checkouttime'].'", NULL, "'.$lang.'", "'.$mode.'")');

		foreach ($avail_parks as $pid){
			$pids[] = $pid->parking_id;
		}

		if (!in_array($selectedId, $pids)) {
			// Sorry, this parking is not available anymore for the given dates and times
		    App::abort(403, 'Unauthorized');
		}

		// Save a Booking
		$booking = new Booking;

		$booking->parking_id = $selectedId;

		$user = Auth::user();
		if($user)
			$booking->user_id = $user->user_id;

		$booking->checkin = $data['checkindate'].' '.$data['checkintime'];
		$booking->checkout = $data['checkoutdate'].' '.$data['checkouttime'];
		$booking->price = $selectedPrice + $selectedProductsPrice;
		$booking->title = $input['title'];
		$booking->firstname = $input['items']['firstname'];
		$booking->lastname = $input['items']['lastname'];
		$booking->mobile = $input['items']['mobile'];
		if( array_key_exists('landline', $input['items']) )
			$booking->landline = $input['items']['landline'];
		$booking->email = $input['items']['email'];
		$booking->car_make = $input['items']['carmake'];
		$booking->car_model = $input['items']['carmodel'];
		$booking->car_reg = $input['items']['carreg'];
		if( array_key_exists('carcolour', $input['items']) )
			$booking->car_colour = $input['items']['carcolour'];
		if( array_key_exists('passengers', $input) )
			$booking->passengers = $input['passengers'];
		if( array_key_exists('newsletter', $input) )
			$booking->newsletter = 'Y';
		if( array_key_exists('country', $input['items']) )
			$booking->country_id = $input['items']['country'];

		$booking->save();
		
		$year = substr(date("Y"), -2);
		if ($user and $user->is_affiliate == 'Y')
			$code = 'AF'.$year;
		else
			$code = 'PL'.$year;

		$booking->booking_ref = $code.$booking->booking_id;

		$affiliate_id = Request::cookie('noaf');
		if((!empty($affiliate_id)) and $affiliate_id != 0) {
			$booking->affiliate_id = $affiliate_id;
		}
=======
		$booking_ref = $this->dispatch(
			new BookParking($request)
		);
>>>>>>> feature_online_payments

		if ($request->payment == 'online') {
			$page = 'payments.bank';
			$ticket = Session::get('TranTicket');

			$configuration = ConfigurationGlobal::where('name', 'like', 'ONLINE%')->get();
			foreach ($configuration as $key => $conf) {
				$config[$conf->name] = $conf->value;
			}

			$summary = Session::get('summary');

			// explicitly set the locale as we are about to enter an unlocalized route
			$locale_tmp = Session::get('locale_tmp');
			app()->setLocale($locale_tmp);
			if ($locale_tmp == 'el')
				$iframe_lang = 'el-GR';
			else
				$iframe_lang = 'en-US';

			$booking = Booking::where('booking_ref', $booking_ref)->firstOrFail();

			return response()->view($page, compact('booking', 'booking_ref', 'config', 'summary', 'iframe_lang'))->withCookie(Cookie::forget('noaf'));
		} else {
			$page = 'static.payment';
			return response()->view($page)->withCookie(Cookie::forget('noaf'));
		}

		return response()->view($page)->withCookie(Cookie::forget('noaf'));
	}

	public function checkout()
	{
		return view('static.checkout');
	}

	/*****************************************/
	/* REST */

	public function index()
	{
		$parkings = DB::table('PARKINGS_V')->get();
		$page_title = 'Parkings';
		return view('admin.parkings.index', compact('parkings', 'page_title'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		$locations = Location::whereNotNull('location_parent_id')->orderBy('name')->get();
		foreach ($locations as $loc)
			$p_locations[$loc->location_id] = $loc->name;

		$p_locations_selected[] = null;


		$fields = Field::orderBy('field_id')->get();
		foreach ($fields as $field)
			$p_fields[$field->field_id] = $field->label;

		$p_fields_selected[] = null;

		$p_options_selected[] = null;

		$tags = Tag::lists('name', 'tag_id');
		//dd($tags);

		$tags_selected = NULL;

		$from_time_bd = 'na';
		$to_time_bd = 'na';
		$from_time_sat = 'na';
		$to_time_sat = 'na';
		$from_time_sun = 'na';
		$to_time_sun = 'na';

		$hours = get_dropdown_hours(); //helpers.php

		$configArray[] = NULL;
		// in case Free minutes not define need to manually add the key in the array
		if (!array_key_exists('FREE_MINUTES', $configArray))
			$configArray['FREE_MINUTES'] = null;

		$page_title = 'Add a new Parking';
		return view('admin.parkings.create', compact('page_title', 'p_locations', 'p_locations_selected', 'p_fields', 'p_fields_selected', 'p_options_selected', 'tags', 'tags_selected',
												'hours', 'from_time_bd', 'to_time_bd', 'from_time_sat', 'to_time_sat', 'from_time_sun', 'to_time_sun', 'configArray'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddParkingRequest $request)
	{
		$input = $request->all();

		$input['payment_methods'] = implode(',', $request->input('payment_options'));

		$parking = Parking::create($input);

		//attach the locations
		$parking->locations()->attach($request->input('locations'));

		//attach the fields
		$parking->fields()->attach($request->input('fields'));

		//attach the tags
		$parking->tags()->attach($request->input('tags'));

		/*** Parking Config entries - START ***/
		if ( $request->input('cancel_threshold') > 0 ){
			add_parking_config($parking->parking_id, 'CANCELLATIONS', 'Y');
			add_parking_config($parking->parking_id, 'CANCEL_THRESHOLD', $request->input('cancel_threshold'));
		}

		if ( $request->input('currency') ){
			add_parking_config($parking->parking_id, 'CURRENCY', $request->input('currency'));
			add_parking_config($parking->parking_id, 'CURRENCY_ORDER', $request->input('currency_order'));
		}

		if ( $request->input('free_minutes') )
			add_parking_config($parking->parking_id, 'FREE_MINUTES', $request->input('free_minutes'));
		/*** Parking Config entries - END ***/

		/*** EXCEL PRICES ***/
		$excel_files = $request->file('pricelist');

		if ($excel_files) {
			$excel_files = Input::file('pricelist');
			$excel_file_count = count($excel_files);
		    // start count how many uploaded
		    $uploadcount = 0;
		    foreach($excel_files as $xfile) {
				$rules = array('file' => 'required|mimes:xls,xlsx'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
				$validator = Validator::make(array('file'=> $file), $rules);
				if($validator->passes()){

					$destinationPath = 'prices/';
					//$filename = $file->getClientOriginalName();
					$filename = $parking->parking_id.'.xlsx';

					$upload_success = $file->move($destinationPath, $filename);

					$uploadcount ++;
				}
		    }
		}

		return redirect('admin/parking');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$parking = Parking::findOrFail($id);

		//$test = json_decode($parking->work_hours, true);
		//dd($test);

		$locations = Location::whereNotNull('location_parent_id')->orderBy('name')->get();
		$parking_locations = ParkingLocation::where('parking_id', '=', $parking->parking_id)->get();

		$p_locations_selected[] = NULL;
		$p_locations = NULL;
		$p_options_selected = NULL;

		foreach ($parking_locations as $p_loc)
			$p_locations_selected[] = $p_loc->location_id;

		foreach ($locations as $loc)
			$p_locations[$loc->location_id] = $loc->name;

		$p_options_selected = explode(',', $parking->payment_methods);

		$fields = Field::orderBy('field_id')->get();
		$parking_fields = ParkingField::where('parking_id', '=', $parking->parking_id)->get();

		$p_fields_selected[] = NULL;
		$p_fields = NULL;

		foreach ($parking_fields as $p_field)
			$p_fields_selected[] = $p_field->field_id;

		foreach ($fields as $field)
			$p_fields[$field->field_id] = $field->label;

		$tags = Tag::lists('name', 'tag_id');
		$tags_selected = $parking->tags->lists('tag_id');

		$configArray[] = NULL;

		$config_response = Configuration::where('parking_id', '=', $id)->get();
		foreach ($config_response as $key => $config) {
			$configArray[$config->conf_name] = $config->value;
		}

		// in case Free minutes not define need to manually add the key in the array
		if (!array_key_exists('FREE_MINUTES', $configArray))
			$configArray['FREE_MINUTES'] = null;

		$page_title = 'Edit Parking';
		return view('admin.parkings.edit', compact('page_title', 'parking', 'p_locations', 'p_locations_selected', 'p_fields', 'p_fields_selected', 'p_options_selected', 'tags', 'tags_selected',
											'hours', 'from_time_bd', 'to_time_bd', 'from_time_sat', 'to_time_sat', 'from_time_sun', 'to_time_sun', 'configArray'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AddParkingRequest $request)
	{
		$input = $request->all();

		$files = $request->file('images');

		$files = Input::file('images');

		$file_count = count($files);

	    // start count how many uploaded
	    $uploadcount = 0;
	    foreach($files as $file) {
			$rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
			$validator = Validator::make(array('file'=> $file), $rules);
			if($validator->passes()){

				$destinationPath = 'img/parkings/'.$id.'/';
				$filename = $file->getClientOriginalName();

				$upload_success = $file->move($destinationPath, $filename);

				//$thumbnail = Image::open($destinationPath.$filename)->thumbnail(new Imagine\Image\Box(300,300));
				$thumbnail = Image::make($destinationPath.$filename, array(
				    'width' => 75,
				    'height' => 75,
				    'crop' => true
				));

				if (!File::exists($destinationPath.'thumb')) {
					$directory = File::makeDirectory($destinationPath.'thumb');
				}

				$thumbnail->save($destinationPath.'thumb/'.$filename);

				$uploadcount ++;
			}
	    }

	    // PRICELIST UPLOAD
	    $excel_files = $request->file('pricelist');

		if ($excel_files) {
			$excel_files = Input::file('pricelist');
			$excel_file_count = count($excel_files);
		    // start count how many uploaded
		    $xls_uploadcount = 0;
		    foreach($excel_files as $xfile) {
				$rules = array('file' => 'required|mimes:xls,xlsx'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
				$validator = Validator::make(array('file'=> $xfile), $rules);
				if($validator->passes()){

					$destinationPath = 'prices/';
					$filename = $id.'.xlsx';

					$upload_success = $xfile->move($destinationPath, $filename);

					$xls_uploadcount ++;
				}
		    }
		}

		$parking = Parking::findOrFail($id);

		if (!empty($request->input('payment_options')))
			$input['payment_methods'] = implode(',', $request->input('payment_options'));
		else
			$input['payment_methods'] = null;

		$parking->update($input);

		if ( $request->input('cancel_threshold') > 0 or empty($request->input('cancel_threshold'))  ){

			$config = Configuration::where('parking_id', '=', $parking->parking_id)->where('conf_name', '=', 'CANCELLATIONS')->first();

			if ($config){

				if ($config->value == 'Y'){

					$cancel_threshold = Configuration::where('parking_id', '=', $parking->parking_id)->where('conf_name', '=', 'CANCEL_THRESHOLD')->first();

					upd_parking_config( $parking->parking_id, 'CANCEL_THRESHOLD', $request->input('cancel_threshold') );
				}

			} else {
				add_parking_config($parking->parking_id, 'CANCELLATIONS', 'Y');
				add_parking_config($parking->parking_id, 'CANCEL_THRESHOLD', $request->input('cancel_threshold'));
			}

		}

		// fetch and update or create
		$configCurrency = Configuration::where('parking_id', '=', $parking->parking_id)->where('conf_name', '=', 'CURRENCY')->first();
		if($configCurrency) {
			$affectedRow1 = Configuration::where('parking_id', '=', $parking->parking_id)->where('conf_name', '=', 'CURRENCY')->update(['value' => $request->input('currency')]);
			$affectedRow1 = Configuration::where('parking_id', '=', $parking->parking_id)->where('conf_name', '=', 'CURRENCY_ORDER')->update(['value' => $request->input('currency_order')]);
		}
		else {
			$config = new Configuration;
			$config->parking_id = $parking->parking_id;
			$config->conf_name = 'CURRENCY';
			$config->value = $request->input('currency');
			$config->save();
		}

		$configFreeMins = Configuration::where('parking_id', '=', $parking->parking_id)->where('conf_name', '=', 'FREE_MINUTES')->first();
		if($configFreeMins) {
			$affectedRow1 = Configuration::where('parking_id', '=', $parking->parking_id)->where('conf_name', '=', 'FREE_MINUTES')->update(['value' => $request->input('free_minutes')]);
		}
		else {
			add_parking_config($parking->parking_id, 'FREE_MINUTES', $request->input('free_minutes'));
		}

		// Update Fields
		if (array_key_exists('fields', $input)) {
			$parking->fields()->sync($request->input('fields'));
		} else {
			$affectedRows = ParkingField::where('parking_id', '=', $parking->parking_id)->delete();
		}

		if ($request->input('locations'))
			$parking->locations()->sync($request->input('locations'));

		if ($request->input('tags'))
			$parking->tags()->sync($request->input('tags'));

		return redirect('/admin/parking');
	}


}
