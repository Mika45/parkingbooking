<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
//use Illuminate\Http\Request;
use Request;
use App\Location;
use App\Configuration;
use App\Parking;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\SearchCombinedRequest;
use Session;
use App;
use Illuminate\Http\Response;

use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Helper\MapHelper;
use Carbon;
use stdClass;
use Log;
use Excel;
use URL;
use LaravelLocalization;

class PagesController extends Controller {

	public $map = NULL;
	public $mapHelper = NULL;

	public function index()
	{
		// NO LONGER NEEDED as it seems that mcamara/laravel-localization already provides that
		// set website locale according to browser language (only when the language is not already set - session)
		/*if (!Session::has('applocale')){
			$browser_lang = get_browser_language();
			App::setLocale($browser_lang);
		}*/

		// this session variable is already used in places so need to keep that logic
		Session::set('applocale', App::getLocale());

		$locationsList = get_locations_for_search(); // in helpers.php

		return view('home', compact('locationsList'));
	}

	public function indextest()
	{

		// set website locale according to browser language (only when the language is not already set - session)
		if (!Session::has('applocale')){
			$browser_lang = get_browser_language();
			App::setLocale($browser_lang);
		}

		//$locationsList = DB::table('LOCATION')->whereNotNull('location_parent_id')->orderBy('name', 'asc')->lists('name','location_id');
		$locationsList = get_locations_for_search(); // in helpers.php

		return view('home2', compact('locationsList'));
	}

	public function search(SearchRequest $request)
	{
		// introduced to use params in the URL so the user will be able to share his search using the URL

		$input = $request->all();
		//dd($input);

		$checkindate = str_replace("/",".", $input['checkindate']);
		//$checkintime = str_replace("/",".", $input['checkindate']);
		$checkoutdate = str_replace("/",".", $input['checkoutdate']);
		//$checkouttime = date('His', strtotime($input['checkouttime']));

		$checkindate = date('Ymd', strtotime($checkindate));
		$checkintime = date('His', strtotime($input['checkintime']));
		$checkoutdate = date('Ymd', strtotime($checkoutdate));
		$checkouttime = date('His', strtotime($input['checkouttime']));

		return redirect('results/'.$input['location'].'/'.$checkindate.'/'.$checkintime.'/'.$checkoutdate.'/'.$checkouttime);
	}

	// Not currently in use (could be used if the results page would contain the search form)
	public function getsearch(SearchCombinedRequest $request)
	{
		
		$location = Session::get('location');
		$checkindate = Session::get('checkindate');
		$checkintime = Session::get('checkintime');
		$checkoutdate = Session::get('checkoutdate');
		$checkouttime = Session::get('checkouttime');

		$checkin = Session::get('checkin');
		$checkout = Session::get('checkout');

		$lang = Session::get('applocale');
		$data = DB::select('CALL GetResults('.$location.', "'.$checkindate.'", "'.$checkintime.'", "'.$checkoutdate.'", "'.$checkouttime.'", NULL, "'.$lang.'")');
		$locationsList = DB::table('LOCATION')->orderBy('name', 'asc')->lists('name','location_id');

		$parkings_array = array();

		foreach ($data as $key => $pid){
			$keys[] = $pid->parking_id;
			$values[] = $pid->price;
			$parkings_array = array_combine($keys, $values);

			$sysdate = Carbon\Carbon::now($pid->timezone); // current date and time of the Parking

			$hourdiff = round((strtotime($checkindate.' '.$checkintime) - strtotime($sysdate))/3600, 1);

			if ($pid->early_booking > $hourdiff)
				$data[$key]->late_booking = 'Y';
			else
				$data[$key]->late_booking = 'N';

			$parking = Parking::Find($pid->parking_id);
			$data[$key]->tags = $parking->tags()->lists('name', 'icon_filename');
		}
		$count = count($parkings_array);
		if (is_null($count))
			$count = 0;

		$lang = Session::get('applocale');
		$location = DB::select('CALL GetLocations("one", '.$location.', "'.$lang.'")');

		$map = build_results_map( $location[0]->lat, $location[0]->lng, $data ); //uses helpers.php
		$mapHelper = new MapHelper();

		return view('results', compact('data', 'locationsList', 'location', 'count', 'map', 'mapHelper', 'checkin', 'checkout'));
		
	}

	public function geturlsearch($in_location_id, $in_from_date, $in_from_time, $in_to_date, $in_to_time)
	{
		$location = $in_location_id;

		$checkindate = date('Y-m-d', strtotime($in_from_date));
		$checkintime = date('H:i:s', strtotime($in_from_time));
		$checkoutdate = date('Y-m-d', strtotime($in_to_date));
		$checkouttime = date('H:i:s', strtotime($in_to_time));

		$checkin = date('d/m/Y', strtotime($in_from_date)).' '.date('H:i', strtotime($in_from_time));
		$checkout = date('d/m/Y', strtotime($in_to_date)).' '.date('H:i', strtotime($in_to_time));

		$lang = Session::get('applocale');
		$query = 'CALL GetResults('.$location.', "'.$checkindate.'", "'.$checkintime.'", "'.$checkoutdate.'", "'.$checkouttime.'", NULL, "'.$lang.'")';
		Log::info('Query = '.$query);

		$data = DB::select($query);
		$locationsList = DB::table('LOCATION')->orderBy('name', 'asc')->lists('name','location_id');

		$parkings_array = array();
		$curs_array = array();

		foreach ($data as $key => $pid){
			$trans_merge = array();
			$keys[] = $pid->parking_id;
			
			$curs_array[$pid->parking_id] = ['currency' => $pid->currency, 'currency_order' => $pid->currency_order];

			$sysdate = Carbon\Carbon::now($pid->timezone); // current date and time of the Parking

			$hourdiff = round((strtotime($checkindate.' '.$checkintime) - strtotime($sysdate))/3600, 1);

			if ($pid->early_booking > $hourdiff)
				$data[$key]->late_booking = 'Y';
			else
				$data[$key]->late_booking = 'N';

			if($pid->rate_type == 'D' or $pid->rate_type == 'C'){
				$price = get_price_from_excel($pid->parking_id, $pid->duration_days);
			} else {
				$price = get_price_from_excel($pid->parking_id, $pid->duration_hours);
			}

			$data[$key]->price = $price['rate'];

			$values[] = $price['rate'];
			$parkings_array = array_combine($keys, $values);

			if (!isset($price['rate']) or $price['rate'] == 0)
				$data[$key]->available = 'N';

			// to make the sorting algorithm work and put the available='N' to the bottom
			if ($data[$key]->available == 'N') 
				$data[$key]->price = 0;

			$parking = Parking::Find($pid->parking_id);

			$data[$key]->tags = $parking->tags()->lists('name', 'icon_filename');

			$tag_trans = get_tag_translations( $pid->parking_id );
			
			foreach ($tag_trans as $value2) {
				$trans_merge[$value2->icon_filename] = $value2->name;
			}

			$data[$key]->tags = $trans_merge + $data[$key]->tags;
		}
		
		$count = count($parkings_array);
		if (is_null($count))
			$count = 0;

		Session::put('allowedParkings', $parkings_array);

		session(['location' 	=> $location,
				 'checkindate' 	=> $checkindate,
				 'checkintime' 	=> $checkintime,
				 'checkoutdate' => $checkoutdate,
				 'checkouttime' => $checkouttime,
				 'checkin'		=> $checkin,
				 'checkout'		=> $checkout,
				 'currency'		=> $curs_array]);

		$lang = App::getLocale();

		$location = DB::select('CALL GetLocations("one", '.$location.', "'.$lang.'")');

		$map = build_results_map( $location[0]->lat, $location[0]->lng, $data ); //uses helpers.php
		$mapHelper = new MapHelper();

		if(!empty($keys)){
			$pids = implode(",", $keys);
			$translations = get_results_translation( $pids, $lang );	
		} else {
			$translations = array();
		}

		usort($data, "cmp");

		//dd($data);

		return view('results', compact('data', 'translations', 'locationsList', 'location', 'count', 'map', 'mapHelper', 'checkin', 'checkout'));
	}

	public function about()
	{
		return view('static.about');
	}

	public function tscs()
	{
		return view('static.tscs');
	}

	public function contact()
	{
		return view('static.contact');
	}

	public function faq()
	{
		return view('static.faq');
	}

	public function privacy()
	{
		return view('static.privacy');
	}

	public function payment_methods()
	{
		return view('static.payment-methods');
	}
	
	public function affiliates()
	{
		return view('static.affiliates');
	}

	public function generatePDF()
	{
		$pdf = App::make('dompdf'); //Note: in 0.6.x this will be 'dompdf.wrapper'
		//$pdf->loadHTML('<h1>Δοκιμή</h1>');
		//$html = 'Δοκιμή';
		//$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
		//$pdf->loadHTML($html);

		$pdf->loadView('emails.booking');
		
		return $pdf->stream();

		//return view('static.affiliates');
	}

	public function getxml_bck()
	{

		$dom = new \DOMDocument('1.0', 'utf-8');

		//$element = $dom->createElement('test', 'This is the root element!');
		$node = $dom->createElement('markers');

		// We insert the new element as root (child of the document)
		$parnode = $dom->appendChild($node);

		$parks = Parking::all();

		//header("Content-type: text/xml");

		foreach($parks as $park){
			$node = $dom->createElement("marker");
			$newnode = $parnode->appendChild($node);
			$newnode->setAttribute('name',$park->parking_name);
			//$newnode->setAttribute("address", $row['address']);
			$newnode->setAttribute('lat', $park->lat);
			$newnode->setAttribute('lng', $park->lng);
		}


		$dom->saveXML();
		dd($dom);

		//return view('map', compact('dom'));

		return $dom->saveXML();

		//return "hello";

		//return view('static.affiliates');
	}

	public function getxml()
	{

		//$dom = new \DOMDocument('1.0', 'utf-8');

		//$element = $dom->createElement('test', 'This is the root element!');
		//$node = $dom->createElement('markers');

		// We insert the new element as root (child of the document)
		//$parnode = $dom->appendChild($node);

		$parks = Parking::all();

		//header("Content-type: text/xml");

		//$dom->saveXML();
		//dd($dom);

		//return view('xml', compact('parks'))->header('Content-Type', 'application/xml');
		return response()->view('xml', compact('parks'))->header('Content-Type', 'application/xml');

		//return $dom->saveXML();

		//return "hello";

		//return view('static.affiliates');
	}

	public function showmap()
	{
		return view('map');
	}

	public function showmap2()
	{
		return view('map2');
	}

	public function domap()
	{
		
		$map = new Map();

		$map->setHtmlContainerId('map_canvas');

		$map->setAsync(true);

		$map->setStylesheetOption('width', '100%');
		$map->setStylesheetOption('height', '400px');

		// Sets the center
		$map->setCenter(0, 0, true);

		// Sets the zoom
		$map->setMapOption('zoom', 10);

		$map->setMapOption('mapTypeId', MapTypeId::ROADMAP);
		$map->setMapOption('mapTypeId', 'roadmap');

		$mapHelper = new MapHelper();
		//echo $mapHelper->renderHtmlContainer($map);
		//echo $mapHelper->renderJavascripts($map);

		//return view('test', compact('map', 'mapHelper'));
		return true;
		
	}

	public function sitemap()
	{
		// create new sitemap object
		$sitemap = App::make("sitemap");

		$currentLocale = App::getLocale();
		$locales = LaravelLocalization::getSupportedLocales();
      unset($locales[$currentLocale]);

      $urls = array('', 'faq', 'about', 'affiliates', 'tscs', 'privacy', 'payment-methods');
      foreach ($urls as $page) {
      	foreach ($locales as $lng => $locale) {
				$translations = [ ['language' => $lng, 'url' => url($lng.'/'.$page)] ];
			}
			$sitemap->add(url($currentLocale.'/'.$page), '2015-08-13T20:10:00+02:00', '1.0', 'daily', [], null, $translations);	
      }
      
      $query = 'CALL GetLocationPages("'.$currentLocale.'")';
      $locationPages = DB::select($query);

      $mainArray = array();

      foreach ($locationPages as $value) {
      	$mainArray[$value->location_id] = $value->url;
      }

      $locales = LaravelLocalization::getSupportedLocales();
      unset($locales[$currentLocale]);

      foreach ($locales as $lng => $locale) {
      	$query = 'CALL GetLocationPages("'.$lng.'")';
      	$data = DB::select($query);
      	foreach ($data as $value) {
      		$transArray[$value->location_id] = $value->url;
      	}
      	$translatedPages[$lng] = $transArray;
      }

      foreach ($mainArray as $locId => $url) {
      	foreach ($translatedPages as $lng => $value) {
      		$trans = [
      						['language' => $lng, 'url' => url($lng.$value[$locId])]
							];
      	}
      	$sitemap->add(url($currentLocale.$url), '2015-08-13T12:30:00+02:00', '0.9', 'monthly', [], null, $trans);
      }

	   // generate your sitemap (format, filename)
	   $sitemap->store('xml', 'sitemap');
	   return $sitemap->render('xml');
	}

}
