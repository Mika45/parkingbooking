<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model {

	protected $table = 'PARKING';
	protected $primaryKey = 'parking_id';

	protected $fillable = ['parking_name', 
						   'status', 
						   'slots', 
						   'rate_type', 
						   'min_duration',
						   'early_booking',
						   'description',
						   'find_it',
						   'image_count',
						   'address',
						   'reserve_notes',
						   'gmaps',
						   'lat',
						   'lng',
						   'timezone',
						   'non_work_hours',
						   'email'];


    public function tags()
    {
    	return $this->belongsToMany('App\Tag', 'PARKING_TAG')->withTimestamps()->orderBy('name');
    }

    /**
	 * Get the value of the model's route key.
	 *
	 * @return mixed
	 */
	public function getRouteKey()
	{
	    $hashids = new \Hashids\Hashids('MySecretSalt');

	    return $hashids->encode($this->getKey());
	}

}
