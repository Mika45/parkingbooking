<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingSchedule extends Model {

	protected $table = 'PARKING_SCHEDULE';

	public $timestamps = false;

	protected $primaryKey = 'schedule_id';

	protected $fillable = ['parking_id', 'day', 'from_hour', 'to_hour', 'driving'];

}
