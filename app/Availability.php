<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model {

	protected $table = 'AVAILABILITY';

	public $timestamps = false;
	
	//protected $primaryKey = 'location_id'; // has composite PK but Laravel does not support it here

	protected $fillable = ['parking_id', 'date', 'time_start', 'time_end', 'slots', 'remaining_slots', 'status'];

}
