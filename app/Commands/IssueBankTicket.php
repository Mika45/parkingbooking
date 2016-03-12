<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

use SoapClient;
use Session;
use DB;

use App\ConfigurationGlobal;

class IssueBankTicket extends Command implements SelfHandling {

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($booking_ref, $booking_price)
	{
		$this->booking_ref = $booking_ref;
		$this->booking_price = $booking_price;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$configuration = ConfigurationGlobal::where('name', 'like', 'ONLINE%')->get();
		
		foreach ($configuration as $key => $conf) {
			$config[$conf->name] = $conf->value;
		}

		$client = new SoapClient($config['ONLINE_TICKETING_WS']);

		$parameters = null;

		$params = array(
			'AcquirerId' => $config['ONLINE_ACQUIRER_ID'],
			'MerchantId' => $config['ONLINE_MERCHANT_ID'],
			'PosId' => $config['ONLINE_POS_ID'],
			'Username' => $config['ONLINE_USERNAME'],
			'Password' => $config['ONLINE_PASSWORD'],
			'RequestType' => $config['ONLINE_REQUEST_TYPE'],
			'CurrencyCode' => $config['ONLINE_CURRENCY_CODE'],
			'MerchantReference' => $this->booking_ref,
			'Amount' => $this->booking_price,
			'Installments' => 0,
			'ExpirePreauth' => 0,
			'Bnpl' => 0,
			'Parameters' => $parameters
		);

		$response = $client->IssueNewTicket(array('Request' => $params));

		Session::put('TranTicket', $response);
	}

}
