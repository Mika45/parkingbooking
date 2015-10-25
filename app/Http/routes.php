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

// taken out of the redirection middlewares (admin backend)
Route::group(['middleware' => 'secure'], function()
{
	Route::resource('parking', 'ParkingsController', ['except' => ['show']]);
	Route::get('parking/{id}/rates', 'RatesController@index');
	Route::get('parking/{id}/schedule', 'ParkingScheduleController@index');
	
	Route::resource('rates', 'RatesController');
	Route::resource('fields', 'FieldsController');
	Route::resource('tags', 'TagsController');
	Route::resource('products', 'ProductsController');
	Route::resource('translations', 'TranslationsController');
	Route::resource('bookings', 'BookingsController');
	Route::resource('availabilities', 'AvailabilitiesController');
	Route::resource('articles', 'ArticlesController');
	Route::resource('schedules', 'ParkingScheduleController');
	Route::resource('locations', 'LocationsController');
	Route::get('availabilities/{id}/create', 'AvailabilitiesController@create');
	Route::get('translations/{type}/{id}', 'TranslationsController@index');
	Route::get('translations/{type}/{id}/create', 'TranslationsController@create');
	Route::get('rates/{id}/create', 'RatesController@create');
	Route::get('schedules/{id}/create', 'ParkingScheduleController@create');
});

Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);
Route::get('sitemap', 'PagesController@sitemap');
// FORCE HTTP - NOT SECURE - NON CRITICAL ROUTES ONLY
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['secure', 'localeSessionRedirect', 'localizationRedirect']], function() //can use unsecure also
{
	Route::get('/', 'PagesController@index');
	Route::get('results', 'PagesController@getsearch');
	Route::post('results', 'PagesController@search');
	Route::get('results/{location_id}/{from_date}/{from_time}/{to_date}/{to_time}', 'PagesController@geturlsearch');

	Route::get('about', 'PagesController@about');
	Route::get('tscs', 'PagesController@tscs');
	Route::get('contact', 'PagesController@contact');
	Route::get('news', 'ArticlesController@showAll');
	Route::get('news/{slug}', 'ArticlesController@show');
	Route::get('faq', 'PagesController@faq');
	Route::get('privacy', 'PagesController@privacy');
	Route::get('affiliates', 'PagesController@affiliates');
	Route::get('payment-methods', 'PagesController@payment_methods');
});

// FORCE HTTPS
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['secure', 'localeSessionRedirect', 'localizationRedirect']], function()
{
	Route::post('payment', 'ParkingsController@payment');
	Route::get('payment/online', 'PaymentsController@bank');
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

Route::get('xml', 'PagesController@getxml');
Route::get('map', 'PagesController@showmap');
Route::get('map2', 'PagesController@showmap2');
Route::get('pdf', 'PagesController@generatePDF');

/***************************************************/

Route::get('/users', 'PagesController@users');