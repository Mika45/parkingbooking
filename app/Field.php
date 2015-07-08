<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model {

	protected $table = 'FIELD';
	
	protected $primaryKey = 'field_id';

	protected $fillable = ['field_name', 'type', 'attributes', 'label'];

}
