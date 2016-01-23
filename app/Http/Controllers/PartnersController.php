<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Response;

use Request;

use App\Http\Requests\AddAffiliateRequest;
use App\Affiliate;
use App\User;
use DB;
use App;

class PartnersController extends Controller {

	public function __construct()
    {
        $this->middleware('auth.admin', ['except' => ['show', 'setCookie']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//$affiliates = DB::table('AFFILIATE')->get();
		$affiliates = DB::select('CALL GetAffiliates()');

		$page_title = 'Affiliates';
		return view('admin.partners.index', compact('affiliates', 'page_title'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$data = DB::select('CALL GetFreeAffiliateUsers()');
		$p_users[] = null;
		foreach ($data as $user)
			$p_users[$user->user_id] = $user->email;

		$p_users_selected[] = null;

		$page_title = 'Add a new Affiliate';
		return view('admin.partners.create', compact('page_title', 'p_users', 'p_users_selected'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddAffiliateRequest $request)
	{
		$input = $request->all();
		//dd($input);
		$affiliate = new Affiliate;
		
		$affiliate->status 		= $input['status'];
		$affiliate->firstname 	= $input['firstname'];
		$affiliate->lastname 	= $input['lastname'];
		$affiliate->email 		= $input['email'];
		$affiliate->landline 	= $input['landline'];
		$affiliate->mobile 		= $input['mobile'];
		$affiliate->referrer 	= $input['referrer'];
		$affiliate->user_id 		= $input['users'][0];
		$affiliate->comments 	= $input['comments'];

		$affiliate->save();

		return redirect('admin/partners');
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
		$p_users_selected[] = null;

		$user = User::find($affiliate->user_id);

		if (isset($user)){
			$p_users[$affiliate->user_id] = $user->email;
		}
		else{
			$data = DB::select('CALL GetFreeAffiliateUsers()');
			$p_users[] = null;
			foreach ($data as $user)
				$p_users[$user->user_id] = $user->email;
		}	

		$page_title = 'Edit Affiliate';
		return view('admin.partners.edit', compact('affiliate', 'page_title', 'p_users_selected', 'p_users'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AddAffiliateRequest $request)
	{
		$input = $request->all();
		$affiliate = Affiliate::findOrFail($id);
		$affiliate->user_id = $input['users'][0];
		$affiliate->update($request->all());
		return redirect('/admin/partners');
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

		return redirect('/')->withCookie(cookie('noaf', $id, 360));
	}

}
