<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\BankRequest;

use Request;

use SoapClient;
use Session;
use App\Commands\CompleteBooking;
use App\Commands\SendVouchers;

use App\Booking;
use Log;

class PaymentsController extends Controller {

	/**
     * Instantiate a new PaymentsController instance.
     */
    public function __construct()
    {
        //$this->middleware('auth'); 
    }

	public function bank()
	{
		$client = new SoapClient("https://paycenter.piraeusbank.gr/services/tickets/issuer.asmx?WSDL");

		$parameters = null;

		$params = array(
			'AcquirerId' => 14,
			'MerchantId' => 2133613386,
			'PosId' => 2139909353,
			'Username' => 'KA009598',
			'Password' => '64c2b64daff31c1e427a0f383713f030',
			'RequestType' => '02',
			'CurrencyCode' => 978,
			'MerchantReference' => 'PL1506',
			'Amount' => 20,
			'Installments' => 0,
			'ExpirePreauth' => 0,
			'Bnpl' => 0,
			'Parameters' => $parameters
		);

		$response = $client->IssueNewTicket(array('Request' => $params));

		Session::put('TranTicket', $response);

		return view('payments.bank');
	}

	public function result($name = null, BankRequest $request)
	{
		// dispatch command to save the Transaction and update the Booking status
		$transaction = $this->dispatch(
			new CompleteBooking($request)
		);

		$lang_msg = null;

		switch ($name) {
			case 'success':
				$booking = Booking::where('booking_ref', $request->input('MerchantReference'))->firstOrFail();
				// Send vouchers
				$this->dispatch(
					new SendVouchers($booking->booking_id)
				);
				break;
			case 'failure':
				if ($transaction->result_code == '981')
					$lang_msg = 'site.pay_invalid_card';
				else
					$lang_msg = 'site.pay_failure_body';

				break;
			case 'cancel':
				break;
			default:
				abort(404);
				break;
		}

		return view('payments.result', compact('name', 'lang_msg'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
