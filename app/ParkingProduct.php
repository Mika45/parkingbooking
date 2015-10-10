<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingProduct extends Model {

	protected $table = 'PARKING_PRODUCT';

	protected $fillable = ['parking_id', 'product_id'];

}
