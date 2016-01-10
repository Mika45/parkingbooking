<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use App\Translation;
use App\Parking;
use App\Location;
use App\Tag;
use App\Article;
use App\Product;
use App\Http\Requests\AddTranslationRequest;
use Illuminate\Routing\Route;
use Config;

class TranslationsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($type, $id)
	{
		$translations = Translation::where('table_name', '=', strtoupper($type))->
									 where('identifier', '=', $id)->orderBy('translation_id')->get();

		// this is mainly to get the parking name and set the <h1> header - not the best solution
		switch ($type) {
			case 'parking':
				$parking = Parking::findOrFail($id);
				$page_description = 'for the Parking: '.$parking->parking_name;
				break;
			case 'location':
				$location = Location::findOrFail($id);
				$page_description = 'for the Location: '.$location->name;
				break;
			case 'tag':
				$tag = Tag::findOrFail($id);
				$page_description = 'for the Tag: '.$tag->name;
				break;
			case 'article':
				$article = Article::findOrFail($id);
				$page_description = 'for the Article: '.$article->title;
				break;
			case 'product':
				$product = Product::findOrFail($id);
				$page_description = 'for the Product: '.$product->name;
				break;
		}

		$identifier = $id;

		$page_title = 'Translations';
		
		return view('admin.translations.index', compact('page_title', 'page_description', 'type', 'translations', 'parking', 'location', 'tag', 'article', 'product', 'identifier'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($type, $id)
	{
		switch ($type) {
			case 'parking':
				$parking = Parking::findOrFail($id);
				$columns = array('description' => 'Description', 'reserve_notes' => 'Reserve notes', 'find_it' => 'Find it', 'address' => 'Address', 'parking_name' => 'Parking Name');
				$identifier = $parking->parking_id;
				$page_description = 'for the Parking: '.$parking->parking_name;
				break;
			case 'location':
				$location = Location::findOrFail($id);
				$columns = array(	'description' => 'Description', 
										'location_page_name' => 'Location Page title', 
										'name' => 'Name', 
										'slug' => 'URL alias',
										'meta_keywords' => 'Meta keywords',
										'meta_description' => 'Meta description' );
				$identifier = $location->location_id;
				$page_description = 'for the Location: '.$location->name;
				break;
			case 'tag':
				$tag = Tag::findOrFail($id);
				$columns = array('name' => 'Name');
				$identifier = $tag->tag_id;
				$page_description = 'for the Tag: '.$tag->name;
				break;
			case 'article':
				$article = Article::findOrFail($id);
				$columns = array('title' => 'Title', 'body' => 'Body', 'slug' => 'URL');
				$identifier = $article->article_id;
				$page_description = 'for the Article: '.$article->title;
				break;
			case 'product':
				$product = Product::findOrFail($id);
				$columns = array('name' => 'Name', 'description' => 'Description');
				$identifier = $product->product_id;
				$page_description = 'for the Product: '.$product->name;
				break;
		}

		$table_name = strtoupper($type);

		foreach (Config::get('app.locales') as $key => $language){
			if ($key != 'en')
				$langs[$key] = $language;
		}

		asort($columns);

		$page_title = 'Create Translations';

		return view('admin.translations.create', compact('page_title', 'page_description', 'type', 'langs', 'parking', 'location', 'tag', 'article', 'product', 'columns', 'table_name', 'identifier'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddTranslationRequest $request)
	{
		$input = $request->all();
		
		$translation = Translation::create($input);

		$type = strtolower($translation->table_name);

		return redirect()->action('TranslationsController@index', ['type' => $type, 'id' => $translation->identifier]);
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
		$translation = Translation::findOrFail($id);

		switch (strtoupper($translation->table_name)) {
			case 'PARKING':
				$parking = Parking::findOrFail($translation->identifier);
				$langs[$translation->locale] = $translation->locale;
				$all_columns = array('description' => 'Description', 'reserve_notes' => 'Reserve notes', 'find_it' => 'Find it', 'address' => 'Address', 'parking_name' => 'Parking Name');
				$identifier = $parking->parking_id;
				$page_description = 'for the Parking '.$parking->parking_name;
				break;
			case 'LOCATION':
				$location = Location::findOrFail($translation->identifier);
				$langs[$translation->locale] = $translation->locale;
				$all_columns = array('description' => 'Description', 'location_page_name' => 'Location Page title', 'name' => 'Name', 'slug' => 'URL alias');
				$identifier = $location->location_id;
				$page_description = 'for the Location '.$location->name;
				break;
			case 'TAG':
				$tag = Tag::findOrFail($translation->identifier);
				$langs[$translation->locale] = $translation->locale;
				$all_columns = array('name' => 'Name');
				$identifier = $tag->tag_id;
				$page_description = 'for the Tag '.$tag->name;
				break;
			case 'ARTICLE':
				$article = Article::findOrFail($translation->identifier);
				$langs[$translation->locale] = $translation->locale;
				$all_columns = array('title' => 'Title', 'body' => 'Body', 'slug' => 'URL');
				$identifier = $article->article_id;
				$page_description = 'for the Article '.$article->title;
				break;
			case 'PRODUCT':
				$product = Product::findOrFail($translation->identifier);
				$langs[$translation->locale] = $translation->locale;
				$all_columns = array('name' => 'Name', 'description' => 'Description');
				$identifier = $product->product_id;
				break;
		}

		$type = strtolower($translation->table_name);
		$table_name = strtoupper($type);
		$columns[$translation->column_name] = $all_columns[$translation->column_name];

		$page_title = 'Edit Translations';

		return view('admin.translations.edit', compact('page_title', 'page_description', 'translation', 'type', 'langs', 'columns', 'table_name', 'identifier'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AddTranslationRequest $request)
	{
		$translation = Translation::findOrFail($id);
		$translation->update($request->all());

		$type = strtolower($translation->table_name);

		return redirect()->action('TranslationsController@index', ['type' => $type, 'id' => $translation->identifier]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//dd($id);
		$translation = Translation::findOrFail($id);
		$translation->delete();
		return redirect()->back()->withInput();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function createParkingTrans($id)
	{
		return view('translations.create');
	}

	/**
     * Instantiate a new ParkingsController instance.
     */
    public function __construct()
    {
        $this->middleware('auth'); 
    }
	
}
