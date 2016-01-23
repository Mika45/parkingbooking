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
        $this->middleware('auth.admin');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tags = DB::table('TAG')->get();
		$page_title = 'Parking Features';
		return view('admin.tags.index', compact('tags', 'page_title'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$page_title = 'Add a new Parking Feature';
		return view('admin.tags.create', compact('page_title'));
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

	   $request->file('icon_filename')->move( base_path() . '/public/img/icons/', $imageName );

		return redirect('/admin/tags');
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
		$page_title = 'Edit a Parking Feature';
		return view('admin.tags.edit', compact('tag', 'page_title'));
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
		
		return redirect('/admin/tags');
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
