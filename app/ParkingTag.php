<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingTag extends Model {

	protected $table = 'PARKING_TAG';

	protected $fillable = ['parking_id', 
						   'tag_id'];

}
