<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use App\Http\Requests\AddArticleRequest;
use App\Article;
use App\Translation;
use Carbon;
use DB;
use Session;
use App;

class ArticlesController extends Controller {

	/**
     * Instantiate a new LocationsController instance.
     */
    public function __construct()
    {
        $this->middleware('auth.admin', ['except' => ['showAll', 'show']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$articles = DB::table('ARTICLE')->get();
		$page_title = 'Articles';
		return view('admin.articles.index', compact('articles', 'page_title'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$page_title = 'Add a new Article';
		return view('admin.articles.create', compact('page_title'));
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
		$article->slug = $input['slug'];

		$article->save();

		return redirect('/admin/articles');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		$translation = Translation::where('value', '=', $slug)
									->where('table_name', '=', 'ARTICLE')
									->where('column_name', '=', 'slug')
									->first();

		if (!empty($translation)){
			$article = Article::findOrFail($translation->identifier);
		} else {
			$article = Article::where('slug', '=', $slug)->first();
		}

		// get the traslations of the current locale
		$translations = get_translation( 'ARTICLE', $article->article_id );

		return view('articles.show', compact('article', 'translations'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showAll()
	{
		$lang = App::getLocale();
		$query = 'CALL GetArticles("'.$lang.'")';
		$articles = DB::select($query);

		return view('articles.all', compact('articles'));
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
		$page_title = 'Edit article';
		return view('admin.articles.edit', compact('article', 'page_title'));
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
		
		return redirect('/admin/articles');
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
