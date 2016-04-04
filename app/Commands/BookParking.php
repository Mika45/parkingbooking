<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Session;
use DB;
use Auth;
use Request;
use Storage;
use Lang;
use App;
use Carbon;
use Validator;
use Image;
use Imagine;
use Cookie;
use SoapClient;

use App\PhoneCode;
use App\Product;
use App\BookingProduct;
use App\Parking;
use App\ParkingField;
use App\ParkingLocation;
use App\Booking;
use App\Location;
use App\User;

use App\Commands\IssueBankTicket;
use App\Commands\SendVouchers;
use Bus;


class BookParking extends Command implements SelfHandling {

	protected $input;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($request)
	{
		$this->input = $request;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$selectedArray = Session::get('selectedParking');
		Session::forget('selectedParking');

		$selectedId = $selectedArray['parking_id'];

		if( $this->input->payment == 'online' ) {
			$selectedPrice = $selectedArray['price_card'];
		} else {
			$selectedPrice = $selectedArray['price'];
		}

		if (array_key_exists('productsPrice', $selectedArray))
			$selectedProductsPrice = $selectedArray['productsPrice'];
		else
			$selectedProductsPrice = 0;

		$data = Session::all();

		// Final check of Availability
		$mode = 'L'; // set the mode for GetResults to (L)ive
		if (Auth::check()){
			if (Auth::user()->debug == 'Y')
				$mode = 'T'; // only set to (T)est if the debug setting is turned on for the particular logged in User
		}
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
		$booking->title = $this->input['title'];
		$booking->firstname = $this->input['items']['firstname'];
		$booking->lastname = $this->input['items']['lastname'];
		$booking->mobile = $this->input['items']['mobile'];
		if( array_key_exists('landline', $this->input['items']) )
			$booking->landline = $this->input['items']['landline'];
		$booking->email = $this->input['items']['email'];
		$booking->car_make = $this->input['items']['carmake'];
		$booking->car_model = $this->input['items']['carmodel'];
		$booking->car_reg = $this->input['items']['carreg'];
		if( array_key_exists('carcolour', $this->input['items']) )
			$booking->car_colour = $this->input['items']['carcolour'];
		if( array_key_exists('passengers', $this->input) )
			$booking->passengers = $this->input['passengers'];
		if( array_key_exists('newsletter', $this->input) )
			$booking->newsletter = 'Y';
		if( array_key_exists('country', $this->input['items']) )
			$booking->country_id = $this->input['items']['country'];
		if( $this->input->payment == 'online' ) {
			$booking->payment_type = 'O'; // (O)nline payment
			$booking->status = 'P'; // The payment is (P)ending - should be updated once it's confirmed via Piraeus
		}

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

		$booking->save();

		$checkProdPrice = 0;

		// Booking Products section
		if (Session::has('selectedProducts')){

			$products = Session::get('selectedProducts');

			foreach ($products as $prod) {
				$product = Product::find($prod);
				$checkProdPrice = $checkProdPrice + $product->price;
			}

			if ($checkProdPrice != $selectedArray['productsPrice'])
				App::abort(403, 'Unauthorized');

			foreach ($products as $prod) {
				$bookingProduct = new BookingProduct;
				$bookingProduct->booking_id = $booking->booking_id;
				$bookingProduct->product_id = $prod;
				$bookingProduct->save();
			}
		}

		// Booking Voucher section - Only proceed with the Voucher if the payment will be received at the car park
		if( $this->input->payment == 'atcarpark' ) {

			//$bid = $booking->booking_id;

			// Send the voucher
			Bus::dispatch(
				new SendVouchers($booking->booking_id)
			);

			$response = $booking->booking_ref;
		} else {

			$ticket = Bus::dispatch(
	      		new IssueBankTicket($booking->booking_ref, $booking->price)
	    	);

			$response = $booking->booking_ref;
		}

		// keep these to put in a session later as 
		// we are about to clear all sessions
		$pname = Session::get('parkingName');
		$checkin = Session::get('checkin');
		$checkout = Session::get('checkout');

		$locale_tmp = Session::get('locale_tmp');

		// remove all sessions and keep Online ticket if it exists
		//Session::flush();

		if (isset($ticket)) {
			Session::put('TranTicket', $ticket);
			//Session::put('MerchantReference', $booking->booking_ref);
		}

		// store a booking summary to be used later in the checkout
		$sum = array(
			'parking_name' => $pname,
			'checkin' => $checkin,
			'checkout' => $checkout,
		);
		Session::put('summary', $sum);

		// recreate this session as previously flushed
		Session::put('locale_tmp', $locale_tmp);

		return $response;
	}

}