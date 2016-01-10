<?php namespace App\Http\Controllers;

//require __DIR__.'/vendor/autoload.php';

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//require __DIR__.'/vendor/autoload.php';

use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Helper\MapHelper;

class TestController extends Controller {

	public function admin()
	{
		return view('admin.dashboard');
	}

	public function test()
	{
		$avail = create_availability( 1, '2015-06-11', '2016-12-31' );
	}

	public function test_()
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

		return view('test', compact('map', 'mapHelper'));
		
	}

}
