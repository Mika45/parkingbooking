<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Request;
//
use App;
use App\Location;
use App\Http\Requests\AddLocationRequest;
use DB;
use Ivory\GoogleMap\Helper\MapHelper;
use Input;

class LocationsController extends Controller {

	/**
     * Instantiate a new LocationsController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$locations = DB::table('LOCATIONS_V')->paginate(10);
		return view('locations.index', compact('locations'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$response = Location::where('location_parent_id', '=', NULL)->orWhere('location_parent_id', '=', 0)->orderBy('name')->get();

		$parents["NULL"] = NULL;

		foreach ($response as $loc)
			$parents[$loc->location_id] = $loc->name;

		//dd($parents);
		
		return view('locations.create', compact('parents'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddLocationRequest $request)
	{
		$input = $request->all();
		//dd($input);

		if ($input['location_parent_id'] == 'NULL')
			Input::merge(array('location_parent_id' => NULL));

		Location::create($input);

		return redirect('locations');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		$lang = App::getLocale();
		$location = DB::select('CALL GetLocationBySlug("'.$slug.'", "'.$lang.'")');

		// get the traslations of the current locale
		$translations = get_translation( 'LOCATION', $location[0]->location_id );
		
		$data = DB::select('CALL GetLocationParkings('.$location[0]->location_id.')');
		
		// create the google map
		$map = build_results_map( $location[0]->lat, $location[0]->lng, $data ); //uses helpers.php
		$mapHelper = new MapHelper();

		$locationsList = get_locations_for_search(); // in helpers.php

		$defaultLocation = $location[0]->location_id;

		return view('locations.show', compact('location', 'map', 'mapHelper', 'translations', 'locationsList', 'defaultLocation'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$location = Location::findOrFail($id);

		$response = Location::where('location_parent_id', '=', NULL)->orWhere('location_parent_id', '=', 0)->orderBy('name')->get();

		$parents[' '] = NULL;

		foreach ($response as $loc)
			$parents[$loc->location_id] = $loc->name;

		return view('locations.edit', compact('location', 'parents'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AddLocationRequest $request)
	{
		$location = Location::findOrFail($id);

		$location->update($request->all());
		
		return redirect('locations');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
