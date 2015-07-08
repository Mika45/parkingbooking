<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddLocationRequest extends Request {

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
		$input = $this->request->all();

		if ($input['location_parent_id'] = 'NULL')
			$rules = [
				'name'	 => 'required',
				'status' => 'required'
			];
		else
			$rules = [
				'name'	 => 'required',
				'status' => 'required',
				'lat'  	 => 'required',
				'lng' 	 => 'required'
			];

		return $rules;
	}

}