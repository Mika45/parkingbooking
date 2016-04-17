<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

use DB;
use Mail;
use File;
use App;
use Lang;

use App\Parking;
use App\User;

class SendVouchers extends Command implements SelfHandling {

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($in_booking_id)
	{
		$this->booking_id = $in_booking_id;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		// send the email to the booking user, to the admin and to the Park's e-mail if it exists
		// Need to save the generated PDF to a temp directory and then include its path as the attachment

		$temp_pdf_name = 'Booking Voucher '.$this->booking_id.'.pdf';

		$booking = DB::select('CALL GetBooking('.$this->booking_id.')');

		$cur_lang = App::getLocale();
		$products = DB::select('CALL GetVoucherProducts('.$this->booking_id.',"'.$cur_lang.'")');

		// get the traslations of the current locale
		$translations = get_parking_translation( $booking[0]->parking_id );

		$pdf = App::make('dompdf');
		$pdf->loadView('emails.voucher', compact('booking', 'products', 'translations'));
		$pdf->save('tmp/'.$temp_pdf_name);

		// Get the parking model to grab the email address of the parking
		$parking = Parking::where('parking_id', '=', $booking[0]->parking_id)->first();

		// Now send the emails
		if(!empty($parking->email)) {
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

		// send to admins who have get_vouchers = 'Y'
		$admins = User::where('is_admin', 'Y')->where('get_vouchers', 'Y')->get();

		if (isset($admins)) {
			// foreach loop to send to admins.
			foreach ($admins as $key => $usr) {
				$recipients[] = $usr->email;
			}

			if (isset($recipients)){
				Mail::send('emails.booking', compact('booking', 'products'), function($message) use($temp_pdf_name, $booking, $recipients)
				{
				   	$message->to($recipients)->subject(Lang::get('emails.voucher_subject'));
					$message->attach('tmp/'.$temp_pdf_name);
				});
			}
		}

		// Delete the generated pdf after the send
		File::delete('tmp/'.$temp_pdf_name);
	}

}
