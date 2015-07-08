<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use App\Field;
use App\Http\Requests\AddFieldRequest;

class FieldsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$fields = Field::orderBy('field_id')->get();
		return view('fields.index', compact('fields'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('fields.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddFieldRequest $request)
	{
		$input = $request->all();
		$field = Field::create($input);

		return redirect('fields');
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
		$field = Field::findOrFail($id);
		return view('fields.edit', compact('field'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AddFieldRequest $request)
	{
		$field = Field::findOrFail($id);
		$field->update($request->all());
		return redirect('fields');
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

	/**
     * Instantiate a new ParkingsController instance.
     */
    public function __construct()
    {
        $this->middleware('auth'); 
    }

}
