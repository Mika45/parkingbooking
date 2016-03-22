<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'secure'], function()
{
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
	Route::controller('dashboard', 'DashboardController');
});

// taken out of the redirection middlewares (admin backend)
Route::group(['middleware' => 'secure'], function()
{
	// this is your GET AJAX route
	Route::get('/ajax/get', function () {
		// pass back some data
		$data   = array('value' => 'some data');
		// return a JSON response
		return  Response::json($data);
	});
	// this is your POST AJAX route
	Route::post('/ajax/post', function () {
		// pass back some data, along with the original data, just to prove it was received
		$data   = array('value' => 'some data', 'input' => Request::input());
		// return a JSON response
		return  Response::json($data);
	});

	Route::get('getRequest', function(){
		if(Request::ajax()){
			return 'getRequest has loaded completely';
		}
	});


	/***************************************************************/

	Route::resource('parking', 'ParkingsController', ['except' => ['show']]); // to remove
	Route::resource('admin/parking', 'ParkingsController', ['except' => ['show']]);
	//Route::get('parking/{id}/rates', 'RatesController@index');
	Route::get('admin/parking/{id}/schedule', 'ParkingScheduleController@index');
	Route::get('admin/parking/{id}/products', 'ProductsController@index');
	//Route::resource('rates', 'RatesController');
	//Route::resource('fields', 'FieldsController');
	Route::resource('admin/tags', 'TagsController');
	Route::resource('admin/products', 'ProductsController');
	Route::resource('admin/translations', 'TranslationsController');
	Route::resource('admin/bookings', 'BookingsController');
	Route::resource('admin/articles', 'ArticlesController');
	Route::resource('admin/schedules', 'ParkingScheduleController');
	Route::resource('admin/locations', 'LocationsController');
	Route::resource('admin/partners', 'PartnersController');
	Route::get('admin/translations/{type}/{id}', 'TranslationsController@index');
	Route::get('admin/translations/{type}/{id}/create', 'TranslationsController@create');
	//Route::get('rates/{id}/create', 'RatesController@create');
	Route::get('admin/schedules/{id}/create', 'ParkingScheduleController@create');
	Route::get('admin/products/{id}/create', 'ProductsController@create');
	Route::get('test', 'TestController@admin');
});

Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);
//Route::get('sitemap', 'PagesController@sitemap');
// FORCE HTTP - NOT SECURE - NON CRITICAL ROUTES ONLY
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['secure', 'localeSessionRedirect', 'localizationRedirect']], function() //can use unsecure also
{
	Route::get('/', 'PagesController@index');
	Route::get('results', 'PagesController@getsearch');
	Route::post('results', 'PagesController@search');
	Route::get('results/{location_id}/{from_date}/{from_time}/{to_date}/{to_time}/{id?}/{ref?}', 'PagesController@geturlsearch');
	Route::get('/noaf={id}&ref={ref}', 'PartnersController@setCookie');
	Route::get('about', 'PagesController@about');
	Route::get('tscs', 'PagesController@tscs');
	Route::get('contact', 'PagesController@contact');
	Route::get('news', 'ArticlesController@showAll');
	Route::get('news/{slug}', 'ArticlesController@show');
	Route::get('faq', 'PagesController@faq');
	Route::get('privacy', 'PagesController@privacy');
	Route::get('affiliates', 'PagesController@affiliates');
	Route::get('payment-methods', 'PagesController@payment_methods');

	Route::get('sitemap', 'PagesController@sitemap');
	Route::get('/sitemap.xml', 'PagesController@sitemap');
});

// FORCE HTTPS
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['secure', 'localeSessionRedirect', 'localizationRedirect']], function()
{
	//Route::post('payment', 'ParkingsController@payment');
	Route::get('checkout', 'ParkingsController@checkout');
	Route::post('checkout', 'ParkingsController@checkout');
	//Route::get('payment/online', 'PaymentsController@bank');
	Route::get('payment/result/{name?}', 'PaymentsController@result');
	
	Route::get('settings', ['middleware' => 'auth', 'uses' => 'UsersController@index']);
	Route::post('settings', 'UsersController@update');
	
	Route::get('mybookings', ['middleware' => 'auth', 'uses' => 'UsersController@mybookings']); 
	Route::get('mybookings/{id}', ['middleware' => 'auth', 'uses' => 'UsersController@generatePDF']);
	Route::get('mybookings/{id}/amend', ['middleware' => 'auth', 'uses' => 'UsersController@amendBooking']);
	Route::post('mybookings/{id}/amend', ['middleware' => 'auth', 'uses' => 'UsersController@postAmendBooking']);
	Route::get('mybookings/{id}/amend/confirm', ['middleware' => 'auth', 'uses' => 'UsersController@postAmendConfirmBooking']);
	Route::get('mybookings/{id}/amend/cancel', ['middleware' => 'auth', 'uses' => 'UsersController@cancelBooking']);

	Route::get('parkings', 'ParkingsController@all'); //was @index
	Route::get('parkings/{id}', 'ParkingsController@view'); //was @show
	Route::get('parkings/{id}/book', 'ParkingsController@book');
	Route::post('parkings/{id}/book', 'ParkingsController@book');
	
	Route::get('parkings/{id}/getRequest', 'ParkingsController@setBookingPrice');
	
	Route::get('locations/{slug}', 'LocationsController@show');
	Route::get('locations/{parent}/{slug}', 'LocationsController@show');
	Route::get('parking/{id}', 'ParkingsController@show');
	Route::get('activate/{code}', 'Auth\AuthController@activateAccount');

	Route::controllers([
		'auth' => 'Auth\AuthController',
		'password' => 'Auth\PasswordController',
	]);

	Route::get('/{slug}', 'LocationPagesController@show');
	Route::get('/{parent}/{slug}', 'LocationPagesController@showChild');

});

//Route::get('payment/online', 'PaymentsController@bank');
Route::post('payment/online', 'ParkingsController@payment');

//Route::get('xml', 'PagesController@getxml');
Route::get('map', 'PagesController@showmap');
Route::get('map2', 'PagesController@showmap2');
Route::get('pdf', 'PagesController@generatePDF');

/***************************************************/

Route::get('/users', 'PagesController@users');

/***********************TEST***********************/


Route::group(['middleware' => 'secure'], function()
{
	/**
	 * Laravel / jQuery AJAX code example
	 * See conversation here: http://laravel.io/forum/04-29-2015-people-asking-about-jquery-ajax
	 *
	 * Drop this code into your App/Http/routes.php file, and go to /ajax/view in your browser
	 * Be sure to bring up the JavaScript console by pressing F12.
	 */

	// This is your View AJAX route - load this in your browser
	Route::get('/ajax/view', function () {

		// really all this should be set up as a view, but I'm showing it here as
		// inline html just to be easy to drop into your routes file and test
		?>

			<!-- jquery library -->
			<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>

			<!-- pass through the CSRF (cross-site request forgery) token -->
			<meta name="csrf-token" content="<?php echo csrf_token() ?>" />

			<!-- some test buttons -->
			<button id="get">Get data</button>
			<button id="post">Post data</button>

			<!-- your custom code -->
			<script>
				// set up jQuery with the CSRF token, or else post routes will fail
				$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
				// handlers
				function onGetClick(event)
				{
					// we're not passing any data with the get route, though you can if you want
					$.get('/ajax/get', onSuccess);
				}
				function onPostClick(event)
				{
					// we're passing data with the post route, as this is more normal
					$.post('/ajax/post', {payload:'hello'}, onSuccess);
				}
				function onSuccess(data, status, xhr)
				{
					// with our success handler, we're just logging the data...
					console.log(data, status, xhr);
					// but you can do something with it if you like - the JSON is deserialised into an object
					console.log(String(data.value).toUpperCase())
				}
				// listeners
				$('button#get').on('click', onGetClick);
				$('button#post').on('click', onPostClick);
			</script>

		<?php
	});
	// this is your GET AJAX route
	Route::get('/ajax/get', function () {
		// pass back some data
		$data   = array('value' => 'some data');
		// return a JSON response
		return  Response::json($data);
	});
	// this is your POST AJAX route
	Route::post('/ajax/post', function () {
		// pass back some data, along with the original data, just to prove it was received
		$data   = array('value' => 'some data', 'input' => Request::input());
		// return a JSON response
		return  Response::json($data);
	});
});