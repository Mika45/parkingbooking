<?php namespace App\Http\Controllers;

use Session;
use App\Parking;
use App\ParkingField;
use App\ParkingLocation;
use App\Booking;
use App\Location;
use App\User;
use App\RateDaily;
use App\Configuration;
use App\Field;
use App\Tag;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App;
use Auth;
use Request;
use Mail;
use Storage;
use File;
use Lang;
use App\Http\Requests\BookRequest;
use App\Http\Requests\AddParkingRequest;
use Input;
use Carbon;
use Validator;
use Image;
use Imagine;

use Ivory\GoogleMap\Helper\MapHelper;

class ParkingsController extends Controller {

	/**
     * Instantiate a new ParkingsController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'book', 'payment']]); 
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

		/*if (!in_array($id, $allowedList) && $is_admin != 'Y') {
		    App::abort(403, 'Unauthorized');
		}*/

		$parking = Parking::findOrFail($id);
		$parking->price = Session::get('allowedParkings')[$parking->parking_id];

		// get the traslations of the current locale
		$translations = get_parking_translation( $id );

		Session::put('selectedParking', $id);

		//dd(Session::all());
		//$lang = Session::get('applocale');
		//dd($lang);
		//$location = DB::select('CALL GetLocations("one", '.$id.', "'.$lang.'")');
		
		$pcur = get_parking_currency($id);
		//dd($pcur);

		// create the google map
		$map = build_map( $parking->lat, $parking->lng, $parking->parking_name ); //uses helpers.php
		$mapHelper = new MapHelper();

		$images = glob('img/parkings/'.$id.'/thumb/*.{jpg,png,gif}', GLOB_BRACE);
		$url = null;

		foreach($images as $img) {
			$url[] = basename($img);
			/*Image::make($img,array(
			    'width' => 300,
			    'height' => 300,
			    'grayscale' => true
			))->save('/img/parkings/.jpg');*/
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

		Session::put('selectedParking', $selectedParking);

		// Delete allowed parkings session array as we have already selected an $id
		// and set it again with the only allowed parking which was selected
		Session::forget('allowedParkings');
		$singleAllowedParking[$selectedParking['parking_id']] = $selectedParking['price'];
		Session::set('allowedParkings', $singleAllowedParking);

		//parking details like name etc.
		$parking = Parking::find($id);

		$fields = DB::select('CALL GetParkingFields( '.$id.' )');
		
		$user = Auth::user();

		// get the traslations of the current locale
		$translations = get_parking_translation( $id );
		
		$title_attributes = NULL;
		foreach ($translations as $key2 => $value2) {
			if ($key2 == 'title'){
				$title_attributes = $value2['attributes'];
				$translations['title'] = $value2['value'];
			}
		}

		return view('parkings.book', compact('fields', 'id', 'user', 'translations', 'parking', 'title_attributes'));
	}

	public function payment(BookRequest $request)
	{
		//Session::forget('bookingInProcess');

		$input = $request->all();

		$selectedArray = Session::get('selectedParking');
		Session::forget('selectedParking');

		$selectedId = $selectedArray['parking_id'];
		$selectedPrice = $selectedArray['price'];

		$data = Session::all();

		// Final check of Availability
		$lang = Session::get('applocale');
		$avail_parks = DB::select('CALL GetResults('.$data['location'].', "'.$data['checkindate'].'", "'.$data['checkintime'].'", "'.$data['checkoutdate'].'", "'.$data['checkouttime'].'", "'.$lang.'")');

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
		$booking->price = $selectedPrice;
		$booking->title = $input['title'];
		$booking->firstname = $input['items']['firstname'];
		$booking->lastname = $input['items']['lastname'];
		$booking->mobile = $input['items']['mobile'];
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

		$booking->save();
		
		$year = substr(date("Y"), -2);
		if ($user and $user->is_affiliate == 'Y')
			$code = 'AF'.$year;
		else
			$code = 'PL'.$year;

		$booking->booking_ref = $code.$booking->booking_id;
		$booking->save();

		// Update the availability - Decrease
		// Disabled at the moment - querying the booking table for availability
		//DB::statement('CALL UpdateAvailability('.$selectedId.', "'.$data['checkindate'].'", "'.$data['checkoutdate'].'", "D")');

		$bid = $booking->booking_id;
		$temp_pdf_name = 'Booking Voucher '.$bid.'.pdf';

		$booking = DB::select('CALL GetBooking('.$booking->booking_id.')');
		
		// get the traslations of the current locale
		$translations = get_parking_translation( $booking[0]->parking_id );

		$pdf = App::make('dompdf');
		$pdf->loadView('emails.voucher', compact('booking', 'translations'));
		$pdf->save('tmp/'.$temp_pdf_name);

		// send the email to the booking user, to the admin and to the Park's e-mail if it exists
		// Need to save the generated PDF to a temp directory and then include its path as the attachment
		
		// Get the parking model to grab the email address of the parking
		$parking = Parking::where('parking_id', '=', $booking[0]->parking_id)->first();

		if(!empty($parking->email)) {
			Mail::send('emails.booking', compact('booking'), function($message) use($temp_pdf_name, $booking, $parking)
			{
			    $message->to($parking->email)->subject(Lang::get('emails.voucher_subject'));
				$message->attach('tmp/'.$temp_pdf_name);
			});
		}

		Mail::send('emails.booking', compact('booking'), function($message) use($temp_pdf_name, $booking)
		{
		    $message->to($booking[0]->email)->subject(Lang::get('emails.voucher_subject'));
			$message->attach('tmp/'.$temp_pdf_name);
		});

		Mail::send('emails.booking', compact('booking'), function($message) use($temp_pdf_name, $booking)
		{
		    $message->to('jimkavouris4@gmail.com')->subject(Lang::get('emails.voucher_subject'));
			$message->attach('tmp/'.$temp_pdf_name);
		});
		
		// Delete the generated pdf after the send
		File::delete('tmp/'.$temp_pdf_name);

		return view('static.payment', compact('fields'));
	}

	/*****************************************/
	/* REST */

	public function index()
	{
		$parkings = Parking::orderBy('parking_name')->paginate(10);
		
		/*foreach ($parkings as $value) {
			$rate = RateDaily::where('parking_id', '=', $value->parking_id)->first();
			if

			if (!is_null($rate))
				$rates[$value->parking_id] = ['hasRate' => 1, 'rateType' => 'D'];
		}*/

		$response_daily = DB::table('RATE_DAILY')
								->select(DB::raw('parking_id, "D" as rate_type, count(*) as rate_count'))
			                    ->groupBy('parking_id');
			                    //->get();

		$response_hourly = DB::table('RATE_HOURLY')
								->select(DB::raw('parking_id, "H" as rate_type, count(*) as rate_count'))
			                    ->groupBy('parking_id')
			                    ->union($response_daily)
			                    ->get();

        foreach ($response_hourly as $value){
        	if ($value->rate_count > 0)
        		$rates[$value->parking_id] = ['hasRate' => 1, 'rateType' => $value->rate_type];
        }

        foreach ($parkings as $value){
        	if (!array_key_exists($value->parking_id, $rates))
        		$rates[$value->parking_id] = ['hasRate' => 0, 'rateType' => $value->rate_type];
        }

		//return $parkings;
		return view('parkings.index', compact('parkings', 'rates'));
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

		return view('parkings.create', compact('p_locations', 'p_locations_selected', 'p_fields', 'p_fields_selected', 'tags', 'tags_selected',
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
		//dd($input);

		$json = '{';
		if ($request->input('non-working-hours-1') == '1'){
			$json = $json.'"business":{"from":"'.$request->input('from_time_bd').'", "to":"'.$request->input('to_time_bd').'"},';
			//{"business":{"from":"00:00", "to":"23:59"}, "saturday":{"from":"07:00", "to":"23:59"},"sunday":{"from":"08:00", "to":"23:00"}}
		}
		
		if ($request->input('non-working-hours-2') == '1'){
			$json = $json.'"saturday":{"from":"'.$request->input('from_time_sat').'", "to":"'.$request->input('to_time_sat').'"},';
			//{"business":{"from":"00:00", "to":"23:59"}, "saturday":{"from":"07:00", "to":"23:59"},"sunday":{"from":"08:00", "to":"23:00"}}
		}

		if ($request->input('non-working-hours-3') == '1'){
			$json = $json.'"sunday":{"from":"'.$request->input('from_time_sun').'", "to":"'.$request->input('to_time_sun').'"}';
			//{"business":{"from":"00:00", "to":"23:59"}, "saturday":{"from":"07:00", "to":"23:59"},"sunday":{"from":"08:00", "to":"23:00"}}
		}

		if (substr($json, -1) == ',')
			$json = substr($json, 0, strlen($json)-1);

		$json = $json.'}';
		//dd(json_decode($json, true));

		if (strlen($json) > 2)
			$input['non_work_hours'] = $json;
		else
			$input['non_work_hours'] = NULL;

		$parking = Parking::create($input);

		foreach ($input['locations'] as $loc){
			$p_location = new ParkingLocation;

			$p_location->parking_id = $parking->parking_id;
			$p_location->location_id = $loc;
			$p_location->status = 'A';

			$p_location->save();
		}

		foreach ($input['fields'] as $field){
			$p_field = new ParkingField;

			$p_field->parking_id = $parking->parking_id;
			$p_field->field_id = $field;
			$p_field->required = 'Y';

			$p_field->save();
		}

		//attach the tags
		$tagIds = $request->input('tags');
		$parking->tags()->attach($request->input('tags'));

		if ( $request->input('cancel_threshold') > 0 ){
			
			$config = new Configuration;
			$config->parking_id = $parking->parking_id;
			$config->conf_name = 'CANCELLATIONS';
			$config->value = 'Y';
			$config->save();

			$config = new Configuration;
			$config->parking_id = $parking->parking_id;
			$config->conf_name = 'CANCEL_THRESHOLD';
			$config->value = $request->input('cancel_threshold');
			$config->save();
		}

		if ( $request->input('currency') ){
			
			$config = new Configuration;
			$config->parking_id = $parking->parking_id;
			$config->conf_name = 'CURRENCY';
			$config->value = $request->input('currency');
			$config->save();

			$config = new Configuration;
			$config->parking_id = $parking->parking_id;
			$config->conf_name = 'CURRENCY_ORDER';
			$config->value = $request->input('currency_order');
			$config->save();
		}


		$sysdate = Carbon\Carbon::now();
		//$avail = create_availability( $parking->parking_id, $sysdate->format('Y-m-d'), '2017-12-31' );

		return redirect('parking');
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
		$p_locations[] = NULL;

		foreach ($parking_locations as $p_loc)
			$p_locations_selected[] = $p_loc->location_id;

		foreach ($locations as $loc)
			$p_locations[$loc->location_id] = $loc->name;


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
		//dd($tags_selected);

		$non_work_hours = json_decode($parking->non_work_hours, true);
		//dd($non_work_hours);

		$from_time_bd = 'na';
		$to_time_bd = 'na';
		$from_time_sat = 'na';
		$to_time_sat = 'na';
		$from_time_sun = 'na';
		$to_time_sun = 'na';

		if (!empty($non_work_hours) and array_key_exists('business', $non_work_hours)){
			$from_time_bd = $non_work_hours['business']['from'];
			$to_time_bd = $non_work_hours['business']['to'];
		}

		if (!empty($non_work_hours) and array_key_exists('saturday', $non_work_hours)){
			$from_time_sat = $non_work_hours['saturday']['from'];
			$to_time_sat = $non_work_hours['saturday']['to'];
		}

		if (!empty($non_work_hours) and array_key_exists('sunday', $non_work_hours)){
			$from_time_sun = $non_work_hours['sunday']['from'];
			$to_time_sun = $non_work_hours['sunday']['to'];
		}

		//dd($to_time_bd);
		$hours = get_dropdown_hours(); //helpers.php

		$config_response = Configuration::where('parking_id', '=', $id)->get();
		foreach ($config_response as $key => $config) {
			$configArray[$config->conf_name] = $config->value;
		}

		return view('parkings.edit', compact('parking', 'p_locations', 'p_locations_selected', 'p_fields', 'p_fields_selected', 'tags', 'tags_selected',
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
		//dd($input);

		$files = $request->file('images');

		//dd($files);
		$files = Input::file('images');
		$file_count = count($files);
	    // start count how many uploaded
	    $uploadcount = 0;
	    foreach($files as $file) {
	    	//dd($file);
			$rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
			$validator = Validator::make(array('file'=> $file), $rules);
			if($validator->passes()){

				$destinationPath = 'img/parkings/'.$id.'/';
				$filename = $file->getClientOriginalName();
				
				$upload_success = $file->move($destinationPath, $filename);

				//
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

		$json = '{';
		if ($request->input('non-working-hours-1') == '1'){
			$json = $json.'"business":{"from":"'.$request->input('from_time_bd').'", "to":"'.$request->input('to_time_bd').'"},';
			//{"business":{"from":"00:00", "to":"23:59"}, "saturday":{"from":"07:00", "to":"23:59"},"sunday":{"from":"08:00", "to":"23:00"}}
		}
		
		if ($request->input('non-working-hours-2') == '1'){
			$json = $json.'"saturday":{"from":"'.$request->input('from_time_sat').'", "to":"'.$request->input('to_time_sat').'"},';
			//{"business":{"from":"00:00", "to":"23:59"}, "saturday":{"from":"07:00", "to":"23:59"},"sunday":{"from":"08:00", "to":"23:00"}}
		}

		if ($request->input('non-working-hours-3') == '1'){
			$json = $json.'"sunday":{"from":"'.$request->input('from_time_sun').'", "to":"'.$request->input('to_time_sun').'"}';
			//{"business":{"from":"00:00", "to":"23:59"}, "saturday":{"from":"07:00", "to":"23:59"},"sunday":{"from":"08:00", "to":"23:00"}}
		}

		if (substr($json, -1) == ',')
			$json = substr($json, 0, strlen($json)-1);

		$json = $json.'}';
		
		if (strlen($json) > 2)
			$input['non_work_hours'] = $json;
		else
			$input['non_work_hours'] = NULL;

		$parking = Parking::findOrFail($id);

		$parking->update($input);
		
		if ( $request->input('cancel_threshold') > 0 ){
			
			$config = Configuration::where('parking_id', '=', $parking->parking_id)->where('conf_name', '=', 'CANCELLATIONS')->first();
			
			if ($config){

				if ($config->value == 'Y'){
					
					$cancel_threshold = Configuration::where('parking_id', '=', $parking->parking_id)->where('conf_name', '=', 'CANCEL_THRESHOLD')->first();
					
					//$cancel_threshold->value = $request->input('cancel_threshold');
					//dd($cancel_threshold);
					$affectedRows = Configuration::where('parking_id', '=', $parking->parking_id)
												->where('conf_name', '=', 'CANCEL_THRESHOLD')
												->update(['value' => $request->input('cancel_threshold')]);
				}

			} else {
				$config = new Configuration;
				$config->parking_id = $parking->parking_id;
				$config->conf_name = 'CANCELLATIONS';
				$config->value = 'Y';
				$config->save();

				$config = new Configuration;
				$config->parking_id = $parking->parking_id;
				$config->conf_name = 'CANCEL_THRESHOLD';
				$config->value = $request->input('cancel_threshold');
				$config->save();
			}

		}

		if (array_key_exists('fields', $input)) {
			foreach ($input['fields'] as $field){
				//$p_field = ParkingField::firstOrCreate(['parking_id' => $parking->parking_id, 'field_id' => $field, 'required' => 'Y']);
				$p_field = ParkingField::firstOrCreate(['parking_id' => $parking->parking_id, 'field_id' => $field]);
			}
		} else {
			$affectedRows = ParkingField::where('parking_id', '=', $parking->parking_id)->delete();
		}

		$tagIds = $request->input('tags');
		//dd($tagIds);
		//$parking->tags()->attach($request->input('tags'));
		$parking->tags()->sync($request->input('tags'));

		//update_availability($id);

		return redirect('parking');
	}


}
