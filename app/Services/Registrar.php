<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'firstname' => 'required|max:50',
			'lastname' => 'required|max:50',
			'mobile' => 'required|max:30',
			'email' => 'required|email|max:50|unique:USER',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		/*
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);
		*/
		
		return User::create([
			'email' 	 => $data['email'],
			'password' 	 => bcrypt($data['password']),
			'title' 	 => $data['title'],
			'firstname'  => $data['firstname'],
			'lastname' 	 => $data['lastname'],
			'mobile' 	 => $data['mobile'],
			'newsletter' => $data['newsletter']
		]);
	}

}
