<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
//use Illuminate\Http\Request;
/********************/
use Auth;
use App\User;
use App\Booking;
use App\Parking;
use App\Amendment;
use App\Configuration;
use App\Availability;
use App\Http\Requests\SettingsRequest;
use App\Http\Requests\AmendRequest;
use App\Http\Requests\AmendConfirmRequest;
use App;
use Session;
use Carbon;
use Request;
use Input;
use Lang;
use Mail;
use Log;
use File;
/********************/

/*
use App\Http\Requests;
//use App\Http\Requests\SettingsRequest;
use App\Http\Controllers\Controller;


use Auth;
use App\User;
use DB;
*/

class UsersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//$userId = Session::get('selectedParking');
		$userId = Auth::user()->user_id;
		$user = User::findOrFail($userId);

		$translations = get_translation('USER', 'NULL');
		//dd($translations);

		//return $userId;

		return view('users.settings', compact('user', 'translations'));
	}

	public function mybookings()
	{
		//$userId = Session::get('selectedParking');
		$userId = Auth::user()->user_id;
		$user = User::findOrFail($userId);

		$bookings = DB::select('CALL GetMyBookings("'.$user->email.'", '.$user->user_id.')');

		$locationsList = get_locations_for_search();

		return view('users.mybookings', compact('user', 'bookings', 'locationsList'));
	}

	public function generatePDF($id)
	{
		$booking = DB::select('CALL GetBooking('.$id.')');

		// get the traslations of the current locale
		$translations = get_parking_translation( $booking[0]->parking_id );

		$cur_lang = App::getLocale();
		$products = DB::select('CALL GetVoucherProducts('.$id.',"'.$cur_lang.'")');

		$pdf = App::make('dompdf');

		$pdf->loadView('emails.voucher', compact('booking', 'products', 'translations'));
		
		return $pdf->stream();
	}

	public function amendBooking($id)
	{

		Session::put('amendParking', $id);

		$locationsList = get_locations_for_search(); // in helpers.php

		//get the booking to send it
		$booking = Booking::findOrFail($id);
		$parking = Parking::findOrFail($booking->parking_id);
		$booking['parking'] = $parking->parking_name;

		Session::flash('checkindate_init', date('Y-m-d', strtotime($booking->checkin)));
		Session::flash('checkintime_init', date('H:i:s', strtotime($booking->checkin)));
		Session::flash('checkoutdate_init', date('Y-m-d', strtotime($booking->checkout)));
		Session::flash('checkouttime_init', date('H:i:s', strtotime($booking->checkout)));

		//check if we can cancel the booking or not
		$conf = Configuration::whereRaw('conf_name = ? and parking_id = ?', ['CANCELLATIONS', $booking->parking_id])->first();
		
		if (is_null($conf)) {
			$cancellations = 'N';
		} else {
			$cancellations = $conf->value;
		}

		return view('users.amend', compact('locationsList', 'booking', 'cancellations'));
	}

	public function postAmendBooking($id, AmendRequest $request)
	{
		$input = $request->all();
		//dd($input);

		/*$checkindate = date('Y-d-m', strtotime($input['checkin']));
		$checkintime = date('H:i:s', strtotime($input['checkin']));
		$checkoutdate = date('Y-d-m', strtotime($input['checkout']));
		$checkouttime = date('H:i:s', strtotime($input['checkout']));*/

		/************************************/
		$checkindate = str_replace("/",".", $input['checkin']);
		$checkoutdate = str_replace("/",".", $input['checkout']);

		// times
		$checkintime = date('H:i:s', strtotime($checkindate));
		$checkouttime = date('H:i:s', strtotime($checkoutdate));

		$checkindate = date('Y-m-d', strtotime($checkindate));
		$checkoutdate = date('Y-m-d', strtotime($checkoutdate));
		/*************************************/

		$cid = Session::get('checkindate_init');
		$cit = Session::get('checkintime_init');
		$cod = Session::get('checkoutdate_init');
		$cot = Session::get('checkouttime_init');

		//check if the data has changed - if not then don't proceed with the db call
		if ( $checkindate == $cid && $checkintime == $cit && $checkoutdate == $cod && $checkouttime == $cot )
			return redirect()->back()->with('msg', Lang::get('site.info_no_changes'));

		//check which submit was clicked on
        if($request->input('search')) {
			$locationsList = get_locations_for_search(); // in helpers.php

			//get the booking to send it
			$booking = Booking::findOrFail($id);
			$parking = Parking::findOrFail($booking->parking_id);
			$booking['parking'] = $parking->parking_name;

			//check if we can cancel the booking or not

			$mode = 'L'; // set the mode for GetResults to (L)ive
			if (Auth::check()){
				if (Auth::user()->debug == 'Y')
					$mode = 'T'; // only set to (T)est if the debug setting is turned on for the particular logged in User
			}
			$lang = App::getLocale();
			//$query = 'CALL GetNewAvailability('.$booking->booking_id.', "'.$checkindate.'", "'.$checkintime.'", "'.$checkoutdate.'", "'.$checkouttime.'")';
			$query = 'CALL GetResults(NULL, "'.$checkindate.'", "'.$checkintime.'", "'.$checkoutdate.'", "'.$checkouttime.'", '.$booking->booking_id.', "'.$lang.'", "'.$mode.'")';
			//a logging proc can go here or wrap the call to a separate API which will include the logging.
			Log::debug('Query = '.$query);
			$data = DB::select($query);
			
			if (empty($data) or empty($data[0]->price) or $data[0]->price == 0){
				//return redirect()->back()->withInput();
				return redirect()->back()->with('msg', Lang::get('site.info_no_slots'));
			} else {
				Input::merge(array('price' => $data[0]->price));
				// put session variables here to retrieve them in postAmendConfirmBooking
			}

			return redirect()->back()->with('amend', 'Y')->withInput();
			//return view('users.amend', compact('locationsList', 'booking'));
        } elseif($request->input('amend')) {
            $booking = Booking::findOrFail($id);

            $amend = new Amendment;
			$amend->booking_id = $booking->booking_id;
			$amend->parking_id = $booking->parking_id;
			$amend->checkin_old = $booking->checkin;
			$amend->checkout_old = $booking->checkout;
			$amend->price_old = $booking->price;
			$amend->checkin_new = $checkindate.' '.$checkintime;
			$amend->checkout_new = $checkoutdate.' '.$checkouttime;
			$amend->price_new = $request->input('price');
			$amend->save();

			$booking->checkin = $checkindate.' '.$checkintime;
			$booking->checkout = $checkoutdate.' '.$checkouttime;
			$booking->price = $request->input('price');
			$booking->status = 'A';
			$booking->save();

			// Send all e-mails (this should be wrapped into a helper and be used in ParkingsController as well)
			$bid = $booking->booking_id;
			$temp_pdf_name = 'Amended Booking Voucher '.$bid.'.pdf';

			$booking = DB::select('CALL GetBooking('.$booking->booking_id.')');
			
			// get the traslations of the current locale
			$translations = get_parking_translation( $booking[0]->parking_id );

			$pdf = App::make('dompdf');
			$pdf->loadView('emails.voucher', compact('booking', 'translations'));
			$pdf->save('tmp/'.$temp_pdf_name);

			// Get the parking model to grab the email address of the parking
			$parking = Parking::where('parking_id', '=', $booking[0]->parking_id)->first();

			if(!empty($parking->email)) {
				Mail::send('emails.amend', compact('booking'), function($message) use($temp_pdf_name, $booking, $parking)
				{
				    $message->to($parking->email)->subject(Lang::get('emails.voucher_subject_amend'));
					$message->attach('tmp/'.$temp_pdf_name);
				});
			}

			Mail::send('emails.amend', compact('booking'), function($message) use($temp_pdf_name, $booking)
			{
			    $message->to($booking[0]->email)->subject(Lang::get('emails.voucher_subject_amend'));
				$message->attach('tmp/'.$temp_pdf_name);
			});

			Mail::send('emails.amend', compact('booking'), function($message) use($temp_pdf_name, $booking)
			{
			    $message->to('jimkavouris4@gmail.com')->subject(Lang::get('emails.voucher_subject_amend'));
				$message->attach('tmp/'.$temp_pdf_name);
			});
			
			// Delete the generated pdf after the send
			File::delete('tmp/'.$temp_pdf_name);

			return redirect('mybookings')->with('message', Lang::get('site.info_amend_ok'));

        }

		
	}

	public function postAmendConfirmBooking($id, AmendConfirmRequest $request)
	{
		//retrieve the session variables as the input cannot be taken with a simple button which is not a submit button of the form
		$input = $request->all();
		dd($input);
	}

	public function cancelBooking($id)
	{

		$locationsList = get_locations_for_search(); // in helpers.php

		//get the booking to create the amendment record
		$booking = Booking::findOrFail($id);

		$parking = Parking::findOrFail($booking->parking_id);

		//check if cancellations are allowed (to be checked before showing the button also)
		
		//check if we can cancel the booking or not
		$conf = Configuration::whereRaw('conf_name = ? and parking_id = ?', ['CANCEL_THRESHOLD', $booking->parking_id])->first();
		
		if (is_null($conf)) {
			$cancel_threshold = 0;
		} else {
			$cancel_threshold = $conf->value;
		}
		
		$sysdate = Carbon\Carbon::now($parking->timezone); // current date and time of the Parking
		
		$hourdiff = round((strtotime($booking->checkin) - strtotime($sysdate))/3600, 1);

		if ($cancel_threshold > $hourdiff)
			return redirect()->back()->with('reason', 'TOO_LATE');

		$amend = new Amendment;
		$amend->booking_id = $booking->booking_id;
		$amend->parking_id = $booking->parking_id;
		$amend->price_old = $booking->price;
		$amend->price_new = NULL;
		$amend->save();

		$booking->status = 'C';
		$booking->save();

		$booking = DB::select('CALL GetBooking('.$booking->booking_id.')');
		if (!empty($parking->email)) 
		{
			Mail::send('emails.cancellation', compact('booking', 'parking'), function($message) use($booking, $parking)
			{
			    $message->to($parking->email)->subject(Lang::get('emails.cancel_subject'));
			});
		}

		$data = Session::all();
		
		return redirect('mybookings')->with('message', Lang::get('site.info_cancel_ok'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	//public function update($id, Request $request)
	public function update(SettingsRequest $request)
	{
		$userId = Auth::user()->user_id;
		$user = User::findOrFail($userId);


		/*if ($user->user_id !== Auth::id()) {
	        abort(403, 'Unauthorized action.');
	    }*/

	    //$input = SettingsRequest::all();
	    //$input = Request::all();
	    $input = $request->all();

	    $user->update($input);

	    return view('users.settings', compact('user'));
	}

}