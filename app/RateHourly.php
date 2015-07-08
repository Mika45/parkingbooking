<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RateHourly extends Model {

	protected $table = 'RATE_HOURLY';
	
	//protected $primaryKey = 'location_id'; // has composite PK but Laravel does not support it here
	protected $primaryKey = 'rate_id';

	protected $fillable = ['parking_id', 'hours', 'price', 'discount', 'free_mins'];

}
