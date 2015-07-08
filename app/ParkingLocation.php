<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingLocation extends Model {

	protected $table = 'PARKING_LOCATION';
	
	//protected $primaryKey = 'location_id'; // has composite PK but Laravel does not support it here

	protected $fillable = ['parking_id', 'location_id', 'status'];

}
