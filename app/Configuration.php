<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model {

	protected $table = 'CONFIGURATION';

	public $timestamps = false;

	protected $fillable = ['parking_id', 'conf_name', 'value'];

}
