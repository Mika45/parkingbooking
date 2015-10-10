<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

	protected $table = 'PRODUCT';
	protected $primaryKey = 'product_id';

	protected $fillable = ['name', 'price', 'description'];

	public function bookings()
	{
		return $this->belongsToMany('App\Booking');
	}

	public function parkings()
	{
		return $this->belongsToMany('App\Parking');
	}

}
