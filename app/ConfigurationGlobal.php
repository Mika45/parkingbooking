<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigurationGlobal extends Model {

	protected $table = 'CONFIGURATION_GLOBAL';

	public $timestamps = false;

	protected $fillable = ['configuration_id', 'name', 'value', 'description'];

}
