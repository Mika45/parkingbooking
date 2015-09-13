<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneCode extends Model {

	protected $table = 'PHONE_CODE';
	
	protected $primaryKey = 'country_id';

	protected $fillable = ['country_id', 'iso2', 'name', 'long_name', 'iso3', 'numcode', 'un_member', 'code', 'cctld'];

}
