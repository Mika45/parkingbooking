<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model {

	protected $table = 'AFFILIATE';
	protected $primaryKey = 'affiliate_id';

	protected $fillable = ['status', 'firstname', 'lastname', 'email', 'landline', 'mobile', 'referrer', 'user_id', 'comments'];

}
