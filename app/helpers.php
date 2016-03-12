<?php

use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Helper\MapHelper;
use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Events\Event;
use Ivory\GoogleMap\Overlays\InfoWindow;

use App\Parking;
use App\Availability;
use App\Configuration;
use App\ConfigurationGlobal;

// My common functions
function set_active($uri)
{
	return Request::is($uri) ? 'active' : null;
}

function set_parent_active($uri)
{
    return Request::is($uri.'*') ? 'active' : null;
}

function link_to_route_icon($properties, $lang_icon)
{
   $m = '<a rel="alternate" hreflang="'.$lang_icon.'" href="'. LaravelLocalization::getLocalizedURL($lang_icon, Request::url()) .'">'
      . $properties['native']
      . '</a>';

   return $m;
}

function get_current_lang_icon()
{
   $m = '<span class="flag-icon flag-icon-'.App::getLocale().'"></span>';
   return $m;
}

function do_markers( $in_data )
{

	$markers = array();

	foreach ($in_data as $parking){
		$marker = new Marker();

		// Configure your marker options
		$marker->setPrefixJavascriptVariable('marker_');
		$marker->setPosition($parking->lat, $parking->lng, true);
		//$marker->setAnimation(Animation::DROP);

		$marker->setOption('clickable', false);
		$marker->setOption('flat', true);
		$marker->setOptions(array(
		    'clickable' => true,
		    'flat'      => true,
		    'title'		=> 'mymarker'
		));

		$infoWindow = new InfoWindow();

		// Configure your info window options
		$infoWindow->setPrefixJavascriptVariable('info_window_');
		$infoWindow->setPosition(0, 0, true);
		$infoWindow->setPixelOffset(1.1, 2.1, 'px', 'pt');
		$infoWindow->setContent($parking->parking_name);
		$infoWindow->setOpen(false);
		$infoWindow->setAutoOpen(true);
		$infoWindow->setOpenEvent('click');
		$infoWindow->setAutoClose(true);
		$infoWindow->setOptions(array(
		    'disableAutoPan' => true,
		    'zIndex'         => 10,
		));

		// Add your info window to the marker
		$marker->setInfoWindow($infoWindow);

		$markers[] = $marker;
	}

	return $markers;
}

function build_results_map( $in_lat, $in_lng, $in_data)
{
	$map = new Map();
	$map->setHtmlContainerId('map_canvas');
	$map->setAsync(true);
	$map->setStylesheetOption('width', '100%');
	$map->setStylesheetOption('height', '437px');
	// Sets the center
	$map->setCenter($in_lat, $in_lng, true);
	// Sets the zoom
	$map->setMapOption('zoom', 11);
	$map->setMapOption('mapTypeId', MapTypeId::ROADMAP);
	$map->setMapOption('mapTypeId', 'roadmap');
	
	$cur_lang = App::getLocale();
	$map->setLanguage($cur_lang);

	/* Now do the markers */

	$markers = array();
	$keys = array();

	foreach ($in_data as $parking){
		$marker = new Marker();
		$marker->setIcon('/img/marker.png');
		// Configure your marker options
		$marker->setPrefixJavascriptVariable('marker_');
		$marker->setPosition($parking->lat, $parking->lng, true);
		//$marker->setAnimation(Animation::DROP);

		$marker->setOption('clickable', false);
		$marker->setOption('flat', true);
		$marker->setOptions(array(
		    'clickable' => true,
		    'flat'      => true,
		    'title'		=> (string)$parking->price
		));

		$infoWindow = new InfoWindow();

		// Configure your info window options
		$infoWindow->setPrefixJavascriptVariable('info_window_');
		$infoWindow->setPosition(0, 0, true);
		$infoWindow->setPixelOffset(1.1, 2.1, 'px', 'pt');
		
		$content = '<h4>'.$parking->parking_name.'</h4><strong>'.$parking->price.'</strong>';

		$infoWindow->setContent($content);

		$infoWindow->setOpen(false);
		$infoWindow->setAutoOpen(true);
		$infoWindow->setOpenEvent('click');
		$infoWindow->setAutoClose(true);
		$infoWindow->setOptions(array(
		    'disableAutoPan' => false,
		    'zIndex'         => 10,
		));

		// Add your info window to the marker
		$marker->setInfoWindow($infoWindow);

		$markers[] = $marker;

		$keys[] = $parking->parking_id;

	}

	

	/**/
	$instances = array();
	// loop through the array to add all the markers to the map
	foreach ($markers as $marker) {
		$map->addMarker($marker);
		
		$instances[] = $marker->getJavascriptVariable();
		//Session::put('JSinstance', $instance);
	}

	$combo = array_combine($keys, $instances);
	//dd($combo);
	Session::put('JSinstances', $combo);

	return $map;
}

//function build_parking_map( $in_lat, $in_lng, $in_title)
function build_map( $in_lat, $in_lng, $in_marker_title)
{
	try {
		
		if (!isset($in_lat) or !isset($in_lng))
			throw new Exception("Latitude and Longtitude parameters must be set");

		$map = new Map();
		$map->setHtmlContainerId('map_canvas');
		$map->setAsync(true);
		$map->setStylesheetOption('width', '100%');
		$map->setStylesheetOption('height', '400px');
		// Sets the center
		$map->setCenter($in_lat, $in_lng, true);
		// Sets the zoom
		$map->setMapOption('zoom', 14);
		$map->setMapOption('mapTypeId', MapTypeId::ROADMAP);
		$map->setMapOption('mapTypeId', 'roadmap');

		$marker = new Marker();
		$marker->setIcon('/img/marker.png');
		// Configure your marker options
		$marker->setPrefixJavascriptVariable('marker_');
		$marker->setPosition($in_lat, $in_lng, true);
		$marker->setAnimation(Animation::DROP);

		$marker->setOption('flat', true);
		$marker->setOptions(array(
		    'clickable' => true,
		    'flat'      => true,
		    'title'		=> $in_marker_title
		));

		$map->addMarker($marker);

		/*************************************/

		$infoWindow = new InfoWindow();

		// Configure your info window options
		$infoWindow->setPrefixJavascriptVariable('info_window_');
		$infoWindow->setPosition(0, 0, true);
		$infoWindow->setPixelOffset(1.1, 2.1, 'px', 'pt');
		$infoWindow->setContent($in_marker_title);
		$infoWindow->setOpen(false);
		$infoWindow->setAutoOpen(true);
		$infoWindow->setOpenEvent('click');
		$infoWindow->setAutoClose(true);
		$infoWindow->setOption('disableAutoPan', false);
		$infoWindow->setOption('zIndex', 10);

		// Add your info window to the marker
		$marker->setInfoWindow($infoWindow);

		$instance = $marker->getJavascriptVariable();
		Session::put('JSinstance', $instance);
	} catch (Exception $e) {
		//var_dump("nope sorry");
		return 'Caught exception: '.$e->getMessage().'\n';
	}

	return $map;
}

function get_parking_translation( $in_parking_id )
{
	$lang = App::getLocale();

	$query = 'CALL GetTranslation("'.$lang.'", NULL, "PARKING", '.$in_parking_id.')';
	Log::info('Query = '.$query);
	$response = DB::select($query);

	$keys = array();
	$values = array();
	foreach ($response as $trans){
		$keys[] = $trans->column_name;
		if (empty($trans->attributes))
			$values[] = $trans->value;
		else
			$values[] = ['value' => $trans->value, 'attributes' => $trans->attributes];
	}
	$translations = array_combine($keys, $values);

	return $translations;
}

function get_translation( $in_table, $in_id, $in_column = NULL )
{
	$lang = App::getLocale();
	
	if (empty($in_column)){
		$response = DB::select('CALL GetTranslation("'.$lang.'", NULL, "'.$in_table.'", '.$in_id.')');
		$keys = array();
		$values = array();
		foreach ($response as $trans){
			$keys[] = $trans->column_name;
			$values[] = $trans->value;
		}
		$translations = array_combine($keys, $values);
	}
	else{
		$response = DB::select('CALL GetTranslation("'.$lang.'", "'.$in_column.'", "'.$in_table.'", '.$in_id.')');
		$translations = $response;
	}	

	return $translations;
}

function get_tag_translations( $in_parking_id )
{
	/*$tagcsv = implode (",", $in_tag_ids);

	$lang = Session::get('applocale');
	//$response = DB::select('CALL GetTranslation("'.$lang.'", NULL, "TAG", NULL)');
	$response = DB::table('TRANSLATION')->whereRaw('table_name = "TAG" and locale = "'.$lang.'" and identifier in ('.$tagcsv.') ')->lists('value', 'identifier');*/
	$lang = App::getLocale();
	$response = DB::select('CALL GetParkingTagTranslation("'.$lang.'",'.$in_parking_id.')');

	return $response;
}

function get_product_translations( $in_parking_id )
{
	$lang = App::getLocale();
	$response = DB::select('CALL GetParkingProductsTranslations("'.$lang.'",'.$in_parking_id.')');

	return $response;
}

function get_results_translation( $in_parking_ids, $in_locale )
{
	$lang = App::getLocale();
	$response = DB::select('CALL GetResultTranslations("'.$in_parking_ids.'", "'.$in_locale.'")');

	$values = array();

	foreach ($response as $key => $trans){
		$values[$trans->parking_id] = $trans;
		unset($values[$trans->parking_id]->parking_id);
	}

	return $values;
}

function get_locations_for_search($parent = 'NULL', $child = 'NULL')
{
	$lang = App::getLocale();
	$locations = DB::select('CALL GetLocations("all", '.$parent.', "'.$lang.'")');

	$locationsList = array();

	foreach ($locations as $loc){
		$parents[$loc->parent_id] = $loc->optgroup;
	}

	foreach ($parents as $key => $opt){
		$sum = NULL;

		foreach ($locations as $loc){
			if ($loc->parent_id == $key)
				$sum[$loc->location_id] = $loc->name;
		}

		$locationsList[$opt] = $sum;
	}

	return $locationsList;
}

function get_locations_for_menu()
{
	$lang = App::getLocale();
	$locations = DB::select('CALL GetLocations("parent", NULL, "'.$lang.'")');

	$links = NULL;
	foreach ($locations as $loc) {
		$links = $links.'<li><a href="'.URL::to('/').'/'.$lang.'/'.$loc->slug.'">'.$loc->name.'</a></li>';
	}

	return $links;
}

function get_parking_rate_type( $in_parking_id )
{
	try 
	{
		$parking = Parking::findOrFail($in_parking_id);
	} 
	catch(\Exception $e) 
	{
		abort(404);
	}

	return $parking->rate_type;
}

function create_availability( $in_parking_id, $in_from_date, $in_to_date )
{
	$parking = Parking::find($in_parking_id);
	$non_work_hours = json_decode($parking->non_work_hours, true);

	$date = date_create($in_from_date);
    $date_end = date_create($in_to_date);

    $from_time_bd = 'na';
	$to_time_bd = 'na';
	$from_time_sat = 'na';
	$to_time_sat = 'na';
	$from_time_sun = 'na';
	$to_time_sun = 'na';

	$from_time = NULL;
	$to_time = NULL;

	if (!empty($non_work_hours) and array_key_exists('business', $non_work_hours)){
		$from_time_bd = $non_work_hours['business']['from'];
		$to_time_bd = $non_work_hours['business']['to'];
	}

	if (!empty($non_work_hours) and array_key_exists('saturday', $non_work_hours)){
		$from_time_sat = $non_work_hours['saturday']['from'];
		$to_time_sat = $non_work_hours['saturday']['to'];
	}

	if (!empty($non_work_hours) and array_key_exists('sunday', $non_work_hours)){
		$from_time_sun = $non_work_hours['sunday']['from'];
		$to_time_sun = $non_work_hours['sunday']['to'];
	}

    while( $date<$date_end ) {

		if ($from_time_sat != 'na' and strtolower($date->format('l')) == 'saturday' ){
			$from_time = $from_time_sat;
			$to_time = $to_time_sat;
		} elseif ($from_time_sun != 'na' and strtolower($date->format('l')) == 'sunday' ){
			$from_time = $from_time_sun;
			$to_time = $to_time_sun;
		} elseif ($from_time_bd != 'na' and strtolower($date->format('l')) != 'sunday' and strtolower($date->format('l')) != 'saturday' ){
			$from_time = $from_time_bd;
			$to_time = $to_time_bd;
		} else {
			$from_time = NULL;
			$to_time = NULL;
		}

		$avail_tbl[] = ['parking_id' => $parking->parking_id, 
						'date' => $date->format('Y-m-d'), 
						'time_start' => $from_time, 
						'time_end' => $to_time, 
						'slots' => $parking->slots,
						'remaining_slots' => $parking->slots,
						'status' => 'A'];

		date_add($date, date_interval_create_from_date_string('1 day'));
    }

    //dd($avail_tbl);
    Availability::insert($avail_tbl);

	return true;
}

function update_availability( $in_parking_id )
{
	$parking = Parking::find($in_parking_id);
	$non_work_hours = json_decode($parking->non_work_hours, true);

	$date = date_create(Carbon\Carbon::now());
	//dd($date->format('Y-m-d'));
    //$date_end = date_create($in_to_date);

    $availability = Availability::where('parking_id', '=', $in_parking_id)->where('date', '>=', $date->format('Y-m-d'))->get();
    //dd($availability);
    $affectedRows = Availability::where('parking_id', '=', $in_parking_id)->where('date', '>=', $date->format('Y-m-d'))->delete();

    $from_time_bd = 'na';
	$to_time_bd = 'na';
	$from_time_sat = 'na';
	$to_time_sat = 'na';
	$from_time_sun = 'na';
	$to_time_sun = 'na';

	$from_time = NULL;
	$to_time = NULL;

	if (!empty($non_work_hours) and array_key_exists('business', $non_work_hours)){
		$from_time_bd = $non_work_hours['business']['from'];
		$to_time_bd = $non_work_hours['business']['to'];
	}

	if (!empty($non_work_hours) and array_key_exists('saturday', $non_work_hours)){
		$from_time_sat = $non_work_hours['saturday']['from'];
		$to_time_sat = $non_work_hours['saturday']['to'];
	}

	if (!empty($non_work_hours) and array_key_exists('sunday', $non_work_hours)){
		$from_time_sun = $non_work_hours['sunday']['from'];
		$to_time_sun = $non_work_hours['sunday']['to'];
	}
	
	foreach ($availability as $key => $value) {

		$date = date_create($value->date);

		if ($from_time_sat != 'na' and strtolower($date->format('l')) == 'saturday' ){
			$from_time = $from_time_sat;
			$to_time = $to_time_sat;
		} elseif ($from_time_sun != 'na' and strtolower($date->format('l')) == 'sunday' ){
			$from_time = $from_time_sun;
			$to_time = $to_time_sun;
		} elseif ($from_time_bd != 'na' and strtolower($date->format('l')) != 'sunday' and strtolower($date->format('l')) != 'saturday' ){
			$from_time = $from_time_bd;
			$to_time = $to_time_bd;
		} else {
			$from_time = NULL;
			$to_time = NULL;
		}

		$avail_tbl[] = ['parking_id' => $value->parking_id, 
						'date' => $value->date, 
						'time_start' => $from_time, 
						'time_end' => $to_time, 
						'slots' => $value->slots,
						'remaining_slots' => $value->remaining_slots,
						'status' => $value->status];

		//date_add($date, date_interval_create_from_date_string('1 day'));
    }

    Availability::insert($avail_tbl);

	return true;
}

function get_dropdown_hours( )
{
	$hours = [
				   '00:00' => '00:00', '01:00' => '01:00',
				   '02:00' => '02:00', '03:00' => '03:00',
				   '04:00' => '04:00', '05:00' => '05:00',
				   '06:00' => '06:00', '07:00' => '07:00',
				   '08:00' => '08:00', '09:00' => '09:00',
				   '10:00' => '10:00', '11:00' => '11:00',
				   '12:00' => '12:00', '13:00' => '13:00',
				   '14:00' => '14:00', '15:00' => '15:00',
				   '16:00' => '16:00', '17:00' => '17:00',
				   '18:00' => '18:00', '19:00' => '19:00',
				   '20:00' => '20:00', '21:00' => '21:00',
				   '22:00' => '22:00', '23:00' => '23:00', 
				   '23:59' => '23:59'
				];

	return $hours;
}

function get_parking_currency( $in_parking_id )
{
	
	$response = Configuration::whereRaw('parking_id = ? and conf_name in (\'CURRENCY\',\'CURRENCY_ORDER\')', [$in_parking_id])->get();

	$result = NULL;

	foreach ($response as $key => $conf) {
		$result[$conf->conf_name] = $conf->value;
	}

	return $result;
}

function get_browser_language()
{
	if ( isset( $_SERVER["HTTP_ACCEPT_LANGUAGE"] ) ){
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	} 
	else {
		$lang = Config::get('app.fallback_locale');
	}

	return $lang;
}

function get_price_from_excel( $in_parking_id, $in_units )
{
	try {

		$xls_path = 'prices/'.$in_parking_id.'.xlsx';

		$file = Excel::selectSheetsByIndex(0)->load($xls_path, function($reader) use ($in_units) {

		    $reader->skip($in_units-1)->take(1);

		})->get();

		$returnArray = array();

		$returnArray['hours'] = 0;
		$returnArray['rate'] = 0;

		foreach ($file as $key => $value) {
			$returnArray['hours'] = $value->hours;
			$returnArray['rate'] = $value->rate;
		}

	} catch (Exception $e) {
		return array('hours' => 0, 'rate' => 0 );
	}

	return $returnArray;
}

function cmp($a, $b)
{
    if ($a->price == 0 or $a->available == 'N') {
        return 1;
    }
    if ($b->price == 0 or $b->available == 'N') {
        return -1;
    }
    return ($a->price < $b->price) ? -1 : 1;
}

function add_parking_config( $in_parking_id, $in_config, $in_value )
{
	$config = new Configuration;
	$config->parking_id = $in_parking_id;
	$config->conf_name = $in_config;
	$config->value = $in_value;
	$config->save();
}

function upd_parking_config( $in_parking_id, $in_config, $in_value )
{
	$config = Configuration::where('parking_id', '=', $in_parking_id)->where('conf_name', '=', $in_config)->first();

	if ($config){
		$affectedRow1 = Configuration::where('parking_id', '=', $in_parking_id)->where('conf_name', '=', $in_config)->update(['value' => $in_value]);
	} else {
		$config = new Configuration;
		$config->parking_id = $in_parking_id;
		$config->conf_name = $in_config;
		$config->value = $in_value;
		$config->save();
	}
}

function get_parkings_dropdown( $in_location_id = NULL, $in_status = NULL )
{
	$parkings = DB::table('PARKING')
					->join('PARKING_LOCATION', 'PARKING.parking_id', '=', 'PARKING_LOCATION.parking_id')
					->select('PARKING.parking_id', 'PARKING.parking_name')
					->orderBy('parking_name')
					->lists('parking_name', 'PARKING.parking_id');

    return $parkings;
}

function get_global_config( $in_config_name )
{
	$config = ConfigurationGlobal::where('name', $in_config_name);
	return $config;
}

?>