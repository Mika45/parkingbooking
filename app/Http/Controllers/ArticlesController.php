<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use App\Http\Requests\AddArticleRequest;
use App\Article;
use Carbon;
use DB;
use Session;

class ArticlesController extends Controller {

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
		$articles = DB::table('ARTICLE')->paginate(15);
		return view('articles.index', compact('articles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('articles.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddArticleRequest $request)
	{
		$input = $request->all();

		$sysdate = Carbon\Carbon::now();

		$article = new Article;
		
		$article->title = $input['title'];
		$article->body = $input['body'];
		$article->created_at = $sysdate;
		$article->updated_at = $sysdate;
		$article->published_at = $sysdate;

		$article->save();

		return redirect('articles');
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
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showAll()
	{
		//$articles = Article::all()->orderBy('article_id', 'desc');

		$lang = Session::get('applocale');
		$query = 'CALL GetArticles("'.$lang.'")';
		$articles = DB::select($query);

		return view('articles.show', compact('articles'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$article = Article::findOrFail($id);
		return view('articles.edit', compact('article'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AddArticleRequest $request)
	{
		$article = Article::findOrFail($id);

		$article->update($request->all());
		
		return redirect('articles');
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
