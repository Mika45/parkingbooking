<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RateDaily extends Model {

	protected $table = 'RATE_DAILY';
	
	//protected $primaryKey = 'location_id'; // has composite PK but Laravel does not support it here
	protected $primaryKey = 'rate_id';

	protected $fillable = ['parking_id', 'day', 'price', 'discount', 'free_mins'];

}
