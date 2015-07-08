<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {

	protected $table = 'BOOKING';
	
	protected $primaryKey = 'booking_id';

	protected $fillable = ['booking_ref',
						   'parking_id', 
						   'user_id',
						   'checkin', 
						   'checkout', 
						   'price', 
						   'title',
						   'firstname',
						   'lastname',
						   'mobile',
						   'email',
						   'car_make',
						   'car_model',
						   'car_reg',
						   'car_colour',
						   'passengers',
						   'newsletter'];

}