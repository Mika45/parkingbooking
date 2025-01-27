<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class SettingsRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		//return false;
		return Auth::check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'email' => 'required|email',
			'firstname' => 'required',
			'lastname' => 'required',
			'mobile' => 'required'
            
		];
	}

}
