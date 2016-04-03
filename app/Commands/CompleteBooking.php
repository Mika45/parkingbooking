<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Transaction;
use App\Booking;

class CompleteBooking extends Command implements SelfHandling {

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
		// save Transaction
		$transaction = New Transaction;

		$transaction->booking_ref = $this->input->MerchantReference;
		$transaction->support_ref_id = $this->input->SupportReferenceID;
		$transaction->result_code = $this->input->ResultCode;
		$transaction->result_description = $this->input->ResultDescription;
		$transaction->status_flag = $this->input->StatusFlag;
		$transaction->response_code = $this->input->ResponseCode;
		$transaction->response_descr = $this->input->ResponseDescription;
		$transaction->bank_transact_id = $this->input->TransactionId;
		$transaction->card_type = $this->input->CardType;

		$transaction->save();

		// update booking
		$booking = Booking::where('booking_ref', $this->input->SupportReferenceID)->firstOrFail();

		if (strtolower($this->input->StatusFlag) == 'success'){
			$booking->status = null;
		} else {
			$booking->status = 'F';
		}

		$booking->save();

		return true;
	}

}
