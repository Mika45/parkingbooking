<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;

use Carbon;
use App\Booking;

class DashboardController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$count_bookings = Booking::whereRaw('DATE(created_at) = DATE(SYSDATE())')->count();

		$stats = array( // put all the dashboard stats into an array for convenience
			'countTodayBookings' => $count_bookings
		);

		$page_title = 'Dashboard';
		return view('admin.dashboard', compact('page_title', 'stats'));
	}

	/**
     * Instantiate a new ParkingsController instance.
     */
	public function __construct()
	{
		$this->middleware('auth.admin');
	}

}