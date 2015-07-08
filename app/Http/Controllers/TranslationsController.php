<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use App\Translation;
use App\Parking;
use App\Location;
use App\Tag;
use App\Http\Requests\AddTranslationRequest;
use Illuminate\Routing\Route;
use Config;

class TranslationsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($type, $id)
	{
		$translations = Translation::where('table_name', '=', strtoupper($type))->
									 where('identifier', '=', $id)->orderBy('translation_id')->get();

		// this is mainly to get the parking name and set the <h1> header - not the best solution
		switch ($type) {
			case 'parking':
				$parking = Parking::findOrFail($id);
				break;
			case 'location':
				$location = Location::findOrFail($id);
				break;
			case 'tag':
				$tag = Tag::findOrFail($id);
				break;
		}
		
		return view('translations.index', compact('type', 'translations', 'parking', 'location', 'tag'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($type, $id)
	{
		switch ($type) {
			case 'parking':
				$parking = Parking::findOrFail($id);
				break;
			case 'location':
				$location = Location::findOrFail($id);
				break;
			case 'tag':
				$tag = Tag::findOrFail($id);
				break;
		}

		foreach (Config::get('app.locales') as $key => $language){
			if ($key != 'en')
				$langs[$key] = $language;
		}

		return view('translations.create', compact('type', 'langs', 'parking', 'location', 'tag'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddTranslationRequest $request)
	{
		$input = $request->all();
		
		$translation = Translation::create($input);

		switch (strtoupper($translation->table_name)) {
			case 'PARKING':
				$type = 'parking';
				break;
			case 'LOCATION':
				$type = 'location';
				break;
			case 'TAG':
				$type = 'tag';
				break;
		}

		return redirect()->action('TranslationsController@index', ['type' => $type, 'id' => $translation->identifier]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$translation = Translation::findOrFail($id);

		switch (strtoupper($translation->table_name)) {
			case 'PARKING':
				$parking = Parking::findOrFail($translation->identifier);
				$type = 'parking';
				$langs[$translation->locale] = $translation->locale;
				break;
			case 'LOCATION':
				$location = Location::findOrFail($translation->identifier);
				$type = 'location';
				$langs[$translation->locale] = $translation->locale;
				break;
			case 'TAG':
				$tag = Tag::findOrFail($translation->identifier);
				$type = 'tag';
				$langs[$translation->locale] = $translation->locale;
				break;
		}

		return view('translations.edit', compact('translation', 'type', 'langs', 'parking', 'location', 'tag'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AddTranslationRequest $request)
	{
		$translation = Translation::findOrFail($id);
		$translation->update($request->all());
		//return redirect('parking');
		//return redirect()->route('translations/{type}/{id}', ['type' => 'parking', 'id' => $translation->identifier]);
		return redirect()->action('TranslationsController@index', ['type' => 'parking', 'id' => $translation->identifier]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//dd($id);
		$translation = Translation::findOrFail($id);
		$translation->delete();
		return redirect()->back()->withInput();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function createParkingTrans($id)
	{
		return view('translations.create');
	}

	/**
     * Instantiate a new ParkingsController instance.
     */
    public function __construct()
    {
        $this->middleware('auth'); 
    }
	
}
