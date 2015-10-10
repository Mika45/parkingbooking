<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

	protected $table = 'TAG';
	protected $primaryKey = 'tag_id';

	protected $fillable = ['name', 'icon_filename'];

	public function parkings()
	{
		return $this->belongsToMany('App\Parking');
	}

}
