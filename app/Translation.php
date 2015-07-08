<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model {

	protected $table = 'TRANSLATION';
	
	protected $primaryKey = 'translation_id';

	public $timestamps = false;

	protected $fillable = ['translation_id', 'locale', 'column_name', 'value', 'table_name', 'identifier'];

}
