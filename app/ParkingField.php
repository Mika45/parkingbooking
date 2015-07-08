<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingField extends Model {

	protected $table = 'PARKING_FIELD';
	
	//protected $primaryKey = 'location_id'; // has composite PK but Laravel does not support it here

	protected $fillable = ['parking_id', 'field_id', 'required'];

}
