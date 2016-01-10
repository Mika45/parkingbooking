<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Request;
//
use App;
use App\Location;
use App\Translation;
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
		$locations = DB::table('LOCATIONS_V')->get();
		$page_title = 'Locations';
		return view('admin.locations.index', compact('locations', 'page_title'));
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

		$page_title = 'Add a new Location';
		return view('admin.locations.create', compact('parents', 'page_title'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddLocationRequest $request)
	{
		$input = $request->all();

		if ($input['location_parent_id'] == 'NULL')
			Input::merge(array('location_parent_id' => NULL));

		if (empty($input['slug']))
			$request->merge(array('slug' => NULL));

		Location::create($input);

		return redirect('/admin/locations');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($parent, $slug)
	{
		$lang = App::getLocale();
		//$location = DB::select('CALL GetLocationBySlug("'.$slug.'", "'.$lang.'")');

		$translation = Translation::where('value', '=', $slug)
									->where('table_name', '=', 'LOCATION')
									->where('column_name', '=', 'slug')
									->first();

		if (!empty($translation)){
			$location = Location::findOrFail($translation->identifier);
		} else {
			$location = Location::where('slug', '=', $slug)->first();
		}

		$parent_loc = DB::table('LOCATIONS_V')->where('parent_slug', '=', $parent)->where('location_id', '=', $location->location_id)->first();
		if(empty($parent_loc)){
			App::abort(404, 'Not Found');
		}

		// get the traslations of the current locale
		$translations = get_translation( 'LOCATION', $location->location_id );
		
		$data = DB::select('CALL GetLocationParkings('.$location->location_id.')');
		
		// create the google map
		$map = build_results_map( $location->lat, $location->lng, $data ); //uses helpers.php
		$mapHelper = new MapHelper();

		$locationsList = get_locations_for_search(); // in helpers.php

		$defaultLocation = $location->location_id;

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

		$page_title = 'Edit a Location';
		return view('admin.locations.edit', compact('location', 'parents', 'page_title'));
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

		$input = $request->all();

		if (empty($input['slug']))
			$request->merge(array('slug' => NULL));

		$location->update($request->all());
		
		return redirect('/admin/locations');
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
