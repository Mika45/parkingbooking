<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App;
use App\Location;
use App\Translation;
use DB;
use Ivory\GoogleMap\Helper\MapHelper;
use Input;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\MapTypeId;

class LocationPagesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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

		$translation = Translation::where('value', '=', $slug)
									->where('table_name', '=', 'LOCATION')
									->where('column_name', '=', 'slug')
									->first();

		if (!empty($translation)){
			$location = Location::findOrFail($translation->identifier);
			//dd($location);
		} else {
			$location = Location::where('slug', '=', $slug)->first();
		}

		/*$parent_loc = DB::table('LOCATIONS_V')->where('parent_slug', '=', $parent)->where('location_id', '=', $location->location_id)->first();
		if(empty($parent_loc)){
			App::abort(404, 'Not Found');
		}*/

		$translations = get_translation( 'LOCATION', $location->location_id );
		
		$data = DB::select('CALL GetLocationParkings('.$location->location_id.')');

		// create the google map
		$map = build_results_map( $location->lat, $location->lng, $data ); //uses helpers.php
		$mapHelper = new MapHelper();

		$locationsList = get_locations_for_search(); // in helpers.php

		$defaultLocation = $location->location_id;

		$child_locations = DB::table('LOCATIONS_V')->where('location_parent_id', '=', $location->location_id)->get();

		return view('locations.parent', compact('location', 'map', 'mapHelper', 'translations', 'locationsList', 'defaultLocation', 'child_locations'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showChild($parent, $slug)
	{
		$lang = App::getLocale();

		$translation = Translation::where('value', '=', $slug)
									->where('table_name', '=', 'LOCATION')
									->where('column_name', '=', 'slug')
									->first();

		if (!empty($translation)){
			$location = Location::findOrFail($translation->identifier);
			//dd($location);
		} else {
			$location = Location::where('slug', '=', $slug)->first();
		}

		$parent_loc = DB::table('LOCATIONS_V')->where('parent_slug', '=', $parent)->where('location_id', '=', $location->location_id)->first();
		if(empty($parent_loc)){
			App::abort(404, 'Not Found');
		}

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
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
