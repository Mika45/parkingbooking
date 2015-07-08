<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Amendment extends Model {

	protected $table = 'AMENDMENT';
	
	protected $primaryKey = 'amend_id';

	protected $fillable = ['amend_id', 'booking_id', 'amended_at', 'parking_id', 'checkin_old', 'checkout_old', 'price_old', 
																				 'checkin_new', 'checkout_new', 'price_new'];

}
