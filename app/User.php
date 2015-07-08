<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'USER';
	
	protected $primaryKey = 'user_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['email', 
						   'password', 
						   'title', 
						   'firstname', 
						   'lastname',
						   'mobile',
						   'car_make',
						   'car_model',
						   'car_reg',
						   'car_colour',
						   'newsletter',
						   'lastlogin',
						   'status',
						   'activation_code',
						   'attempts',
						   'lang',
						   'is_admin',
						   'is_affiliate',
						   'discount'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function getAuthPassword()
	{
	    return $this->password;
	}

	public function accountIsActive($code) 
	{
		$user = User::where('activation_code', '=', $code)->first();
		$user->status = 'A';
		$user->activation_code = '';
		
		if($user->save()) {
			\Auth::login($user);
		}
		
		return true;
	}

}
