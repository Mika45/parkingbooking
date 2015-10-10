<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;
use App\Field;
use Session;

class BookRequest extends Request {

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

		$rules = array();
		
		foreach($this->request->get('items') as $key => $val)
		{

			switch ($key) {
			    case 'firstname':
			        $rules['items.'.$key] = 'required|max:50';
			        break;
			    case 'lastname':
			        $rules['items.'.$key] = 'required|max:50';
			        break;
			    case 'email':
			        $rules['items.'.$key] = 'required|email';
			        break;
			    case 'terms':
			        $rules['items.'.$key] = 'required';
			        break;
			    default: 
			    	$rules['items.'.$key] = 'required';
			}

		}

		if (!array_key_exists('terms', $this->request->get('items')))
			$rules['items.terms'] = 'required';

		return $rules;
	}

	public function messages()
	{
		$messages = [];

		// the key of this session array is the Parking ID
		$currentParkingID = key(Session::get('allowedParkings'));

		$translations = get_parking_translation( $currentParkingID );
		
		if (empty($translations))
			$fields = Field::all()->lists('label', 'field_name');

	  	foreach($this->request->get('items') as $key => $val)
	  	{
	    	
	    	if ($key == 'email')
	    		//The E-mail Address field must be a valid email address'
	    		$messages['items.'.$key.'.email'] = Lang::get('validation.email_fixed');

	    	if ($key == 'terms')
	    		$messages['items.'.$key.'.required'] = Lang::get('validation.email_fixed');
	    	else
	    		//$messages['items.'.$key.'.required'] = 'The field '.$fields[$key].' is required';
				if (array_key_exists($key, $translations))
					$field_label = $translations[$key];
				else
					$field_label = $fields[$key];
				
	    		$messages['items.'.$key.'.required'] = Lang::get('validation.required', ['attribute' => $field_label]);
	  	}
	  	
	  	if (!array_key_exists('terms', $this->request->get('items')))
			$messages['items.terms.required'] = Lang::get('validation.terms');

	  	return $messages;
	}

}