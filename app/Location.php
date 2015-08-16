<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

	protected $table = 'LOCATION';
	protected $primaryKey = 'location_id';

	protected $fillable = ['name', 'status', 'location_parent_id', 'lat', 'lng', 'currency', 'currency_order', 'description', 'slug'];

}
