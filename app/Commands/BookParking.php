<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Session;
use DB;
use Auth;
use Request;
use Mail;
use Storage;
use Lang;
use File;
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
		//dd($this->input);
		$selectedArray = Session::get('selectedParking');
		Session::forget('selectedParking');

		$selectedId = $selectedArray['parking_id'];
		$selectedPrice = $selectedArray['price'];

		if (array_key_exists('productsPrice', $selectedArray))
			$selectedProductsPrice = $selectedArray['productsPrice'];
		else
			$selectedProductsPrice = 0;

		$data = Session::all();

		// Final check of Availability
		$lang = Session::get('applocale');
		$avail_parks = DB::select('CALL GetResults('.$data['location'].', "'.$data['checkindate'].'", "'.$data['checkintime'].'", "'.$data['checkoutdate'].'", "'.$data['checkouttime'].'", NULL, "'.$lang.'")');

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
			$bid = $booking->booking_id;
			$temp_pdf_name = 'Booking Voucher '.$bid.'.pdf';

			$booking = DB::select('CALL GetBooking('.$booking->booking_id.')');

			$cur_lang = App::getLocale();
			$products = DB::select('CALL GetVoucherProducts('.$bid.',"'.$cur_lang.'")');
			
			// get the traslations of the current locale
			$translations = get_parking_translation( $booking[0]->parking_id );

			$pdf = App::make('dompdf');
			$pdf->loadView('emails.voucher', compact('booking', 'products', 'translations'));
			$pdf->save('tmp/'.$temp_pdf_name);

			// send the email to the booking user, to the admin and to the Park's e-mail if it exists
			// Need to save the generated PDF to a temp directory and then include its path as the attachment
			
			// Get the parking model to grab the email address of the parking
			$parking = Parking::where('parking_id', '=', $booking[0]->parking_id)->first();

			/*if(!empty($parking->email)) {
				Mail::send('emails.booking', compact('booking', 'products'), function($message) use($temp_pdf_name, $booking, $parking)
				{
				   $message->to($parking->email)->subject(Lang::get('emails.voucher_subject'));
					$message->attach('tmp/'.$temp_pdf_name);
				});
			}

			Mail::send('emails.booking', compact('booking', 'products'), function($message) use($temp_pdf_name, $booking)
			{
				$message->to($booking[0]->email)->subject(Lang::get('emails.voucher_subject'));
				$message->attach('tmp/'.$temp_pdf_name);
			});

			Mail::send('emails.booking', compact('booking', 'products'), function($message) use($temp_pdf_name, $booking)
			{
			   $message->to('jimkavouris4@gmail.com')->subject(Lang::get('emails.voucher_subject'));
				$message->attach('tmp/'.$temp_pdf_name);
			});*/

			// Delete the generated pdf after the send
			File::delete('tmp/'.$temp_pdf_name);

			$response = $booking[0]->booking_ref;
		} else {

			$ticket = Bus::dispatch(
	      		new IssueBankTicket($booking->booking_ref, $booking->price)
	    	);

			$response = $booking->booking_ref;
		}

		// remove all sessions and keep Online ticket if it exists
		Session::flush();

		if (isset($ticket)) {
			Session::put('TranTicket', $ticket);
			//Session::put('MerchantReference', $booking->booking_ref);
		}

		return $response;
	}

}