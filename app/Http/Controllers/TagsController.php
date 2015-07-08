<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddTagRequest;
use Request;
use App\Tag;
use DB;

class TagsController extends Controller {

	/**
     * Instantiate a new LocationsController instance.
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
	public function index()
	{
		$tags = DB::table('TAG')->paginate(10);
		return view('tags.index', compact('tags'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tags.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddTagRequest $request)
	{
		$input = $request->all();
		
		$imageName = $request->file('icon_filename')->getClientOriginalName();

		$tag = new Tag();
		$tag->name = $input['name'];
		$tag->icon_filename = $imageName;
		$tag->save();

		//dd(base_path());

	    $request->file('icon_filename')->move( base_path() . '/public/img/icons/', $imageName );

		return redirect('tags');
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
		$tag = Tag::findOrFail($id);

		//$response = Location::where('location_parent_id', '=', NULL)->orWhere('location_parent_id', '=', 0)->orderBy('name')->get();

		//$parents[' '] = NULL;

		//foreach ($response as $loc)
			//$parents[$loc->location_id] = $loc->name;

		return view('tags.edit', compact('tag'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AddTagRequest $request)
	{
		$tag = Tag::findOrFail($id);

		$tag->update($request->all());
		
		return redirect('tags');
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
