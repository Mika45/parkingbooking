<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddParkingRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'parking_name'  => 'required',
			'rate_type' 	=> 'required',
			'min_duration'  => 'required',
			'status' 		=> 'required',
			'lat'  			=> 'required',
			'lng' 			=> 'required',
			'slots'  		=> 'required',
			'address' 		=> 'required',
			'description'  	=> 'required',
			'find_it' 		=> 'required',
			'reserve_notes' => 'required',
			'currency' 		=> 'required'
		];
	}

}
