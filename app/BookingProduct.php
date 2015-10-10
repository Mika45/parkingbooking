<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingProduct extends Model {

	protected $table = 'BOOKING_PRODUCT';

	protected $fillable = ['booking_id', 'product_id'];

}
