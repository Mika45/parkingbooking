<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Response;

use Request;

use App\Http\Requests\AddAffiliateRequest;
use App\Affiliate;
use DB;
use App;

class PartnersController extends Controller {

	public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'setCookie']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$affiliates = DB::table('AFFILIATE')->paginate(15);
		return view('partners.index', compact('affiliates'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('partners.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddAffiliateRequest $request)
	{
		$input = $request->all();

		$affiliate = new Affiliate;
		
		$affiliate->status 		= $input['status'];
		$affiliate->firstname 	= $input['firstname'];
		$affiliate->lastname 	= $input['lastname'];
		$affiliate->email 		= $input['email'];
		$affiliate->landline 	= $input['landline'];
		$affiliate->mobile 		= $input['mobile'];
		$affiliate->referrer 	= $input['referrer'];
		$affiliate->comments 	= $input['comments'];

		$affiliate->save();

		return redirect('partners');
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
		$affiliate = Affiliate::findOrFail($id);
		return view('partners.edit', compact('affiliate'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AddAffiliateRequest $request)
	{
		$affiliate = Affiliate::findOrFail($id);
		$affiliate->update($request->all());
		return redirect('partners');
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

	public function setCookie($id, $ref)
	{
		$affiliate = Affiliate::findOrFail($id);

		if ($affiliate->referrer != $ref)
			App::abort(403, 'Unauthorized');

		return redirect('/')->withCookie(cookie('noaf', $id, 15));
	}

}
