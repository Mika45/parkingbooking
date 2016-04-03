<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

	protected $table = 'TRANSACTION';

	protected $primaryKey = 'transaction_id';

	protected $fillable = [
		'transaction_id',
		'booking_ref',
		'support_ref_id',
		'result_code',
		'result_description',
		'status_flag',
		'response_code',
		'response_description',
		'bank_transact_id',
		'card_type'
	];

}
