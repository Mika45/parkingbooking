<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use App\Parking;
use App\ParkingSchedule;
use App\Http\Requests\AddSchedulesRequest;
use DB;
use Session;

class ParkingScheduleController extends Controller {

	/**
     * Instantiate a new ParkingScheduleController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		$times = DB::table('SCHEDULE_V')->where('parking_id', $id)->get();
		$page_title = 'Parking Schedule';
		return view('admin.schedules.index', compact('times', 'id', 'page_title'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		$pid = $id;
		Session::put('scheduleParkingID', $pid);

		try 
		{
			$parking = Parking::findOrFail($pid);
		} 
		catch(\Exception $e) 
		{
			abort(404);
		}

		$page_title = 'Add new Schedule entry';
		
		return view('admin.schedules.create', compact('parking', 'page_title'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddSchedulesRequest $request)
	{
		$input = $request->all();
		$pid = Session::get('scheduleParkingID');

		$schedule = new ParkingSchedule;
		$schedule->parking_id = $pid;
		$schedule->day = $input['day'];
		$schedule->from_hour = $input['from_hour'];
		$schedule->to_hour = $input['to_hour'];
		$schedule->driving = $input['driving'];
		$schedule->save();

		return redirect('admin/parking/'.$pid.'/schedule');
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
		$schedule = ParkingSchedule::findOrFail($id);
		$page_title = 'Edit Schedule entry';
		return view('admin.schedules.edit', compact('schedule', 'page_title'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AddSchedulesRequest $request)
	{
		$schedule = ParkingSchedule::findOrFail($id);
		$schedule->update($request->all());

		return redirect('admin/parking/'.$schedule->parking_id.'/schedule');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$schedule = ParkingSchedule::findOrFail($id);
		$pid = $schedule->parking_id;
		$schedule->delete();
		return redirect('admin/parking/'.$pid.'/schedule');
	}

}
