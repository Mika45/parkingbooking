<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use App\Parking;
use App\RateDaily;
use App\RateHourly;
use App\Http\Requests\AddRatesRequest;
use Session;

class RatesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		//$rate_type = get_parking_rate_type( $id ); //in helpers
		try 
		{
			$parking = Parking::findOrFail($id);
		} 
		catch(\Exception $e) 
		{
			abort(404);
		}

		if ($parking->rate_type == 'D' or $parking->rate_type == 'C')
			$rates = RateDaily::where('parking_id', '=', $id)->get();
		elseif ($parking->rate_type == 'H')
			$rates = RateHourly::where('parking_id', '=', $id)->get();
		else
			$rates = NULL;

		//set a session with the current parking_id to pass it to the route /rates/{rateid}/edit
		//because I can't pass it with a URL parameter - rateid already passed as id
		Session::put('rateParkingID', $id);

		return view('rates.index', compact('rates', 'parking'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		$pid = $id;
		Session::put('rateParkingID', $pid);

		try 
		{
			$parking = Parking::findOrFail($pid);
		} 
		catch(\Exception $e) 
		{
			abort(404);
		}
		
		return view('rates.create', compact('parking'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddRatesRequest $request)
	{
		$input = $request->all();
		$pid = Session::get('rateParkingID');
		
		$rate_type = get_parking_rate_type( $pid );

		if ($rate_type == 'D' or $rate_type == 'C') {
			$rate = new RateDaily;
			$rate->parking_id = $pid;
			$rate->day = $input['day'];
			$rate->price = $input['price'];
			$rate->discount = $input['discount'];
			$rate->free_mins = $input['free_mins'];
			$rate->save();
		} elseif ($rate_type == 'H') {
			$rate = new RateHourly;
			$rate->parking_id = $pid;
			$rate->hours = $input['hours'];
			$rate->price = $input['price'];
			$rate->discount = $input['discount'];
			$rate->free_mins = $input['free_mins'];
			$rate->save();
		}

		return redirect('parking/'.$pid.'/rates');

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
		// the $id here is the rate_id

		$pid = Session::get('rateParkingID');

		try 
		{
			$parking = Parking::findOrFail($pid);
		} 
		catch(\Exception $e) 
		{
			abort(404);
		}

		if ($parking->rate_type == 'D' or $parking->rate_type == 'C')
			$rate = RateDaily::findOrFail($id);
		elseif ($parking->rate_type == 'H')
			$rate = RateHourly::findOrFail($id);
		else
			$rate = NULL;

		return view('rates.edit', compact('rate', 'parking'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AddRatesRequest $request)
	{
		$pid = Session::get('rateParkingID');

		$rate_type = get_parking_rate_type( $pid ); //in helpers

		if ($rate_type == 'D' or $rate_type == 'C')
			$rate = RateDaily::findOrFail($id);
		elseif ($rate_type == 'H')
			$rate = RateHourly::findOrFail($id);
		else
			$rate = NULL;

		$rate->update($request->all());

		//return redirect()->back();
		return redirect('parking/'.$pid.'/rates');
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
