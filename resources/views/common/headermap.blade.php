<!doctype html>
<html>
	<head>
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		{!! HTML::script('js/moment.js') !!}
		{!! HTML::style('css/bootswatch.min.css') !!}
		<!-- Latest compiled and minified JavaScript -->
		{!! HTML::script('js/bootstrap.js') !!}
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<!-- Optional theme -->
		<!--{!! HTML::style('css/bootstrap-theme.css') !!}-->
		{!! HTML::style('css/bootstrap-theme2.css') !!}
		{!! HTML::script('js/bootstrap-datetimepicker.js') !!}
		{!! HTML::style('css/bootstrap-datetimepicker.css') !!}
		{!! HTML::style('css/select2.min.css') !!}
		{!! HTML::script('js/select2.min.js') !!}

		{!! HTML::style('css/flag-icon.css') !!}

		<style>
			.bs-glyphicons-list{padding-left:0;list-style:none}
			/*.bs-glyphicons li{float:left;width:25%;height:115px;padding:10px;font-size:10px;}*/
			.glyphicon-ok{margin-top:5px;margin-bottom:10px;font-size:24px}
		</style>

		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

		<script type="text/javascript">
	    //<![CDATA[

	    var customIcons = {
	      restaurant: {
	        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
	      },
	      bar: {
	        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
	      }
	    };

	    function load() {
	      var map = new google.maps.Map(document.getElementById("map"), {
	        center: new google.maps.LatLng(51.544231, -0.1256312),
	        zoom: 13,
	        mapTypeId: 'roadmap'
	      });
	      var infoWindow = new google.maps.InfoWindow;

	      // Change this depending on the name of your PHP file
	      //downloadUrl("phpsqlajax_genxml.php", function(data) {
	      downloadUrl("http://www.parkinglegend.com/xml", function(data) {
	        var xml = data.responseXML;
	        var markers = xml.documentElement.getElementsByTagName("marker");
	        for (var i = 0; i < markers.length; i++) {
	          var name = markers[i].getAttribute("name");
	          //var address = markers[i].getAttribute("address");
	          //var type = markers[i].getAttribute("type");
	          var point = new google.maps.LatLng(
	              parseFloat(markers[i].getAttribute("lat")),
	              parseFloat(markers[i].getAttribute("lng")));
	          var html = "<b>" + name + "</b> <br/>";
	          var icon = customIcons["bar"] || {};
	          var marker = new google.maps.Marker({
	            map: map,
	            position: point,
	            icon: icon.icon
	          });
	          bindInfoWindow(marker, map, infoWindow, html);
	        }
	      });
	    }

	    function bindInfoWindow(marker, map, infoWindow, html) {
	      google.maps.event.addListener(marker, 'click', function() {
	        infoWindow.setContent(html);
	        infoWindow.open(map, marker);
	      });
	    }

	    function downloadUrl(url, callback) {
	      var request = window.ActiveXObject ?
	          new ActiveXObject('Microsoft.XMLHTTP') :
	          new XMLHttpRequest;

	      request.onreadystatechange = function() {
	        if (request.readyState == 4) {
	          request.onreadystatechange = doNothing;
	          callback(request, request.status);
	        }
	      };

	      request.open('GET', url, true);
	      request.send(null);
	    }

	    function doNothing() {}

	    //]]>

	  </script>
		
	</head>
    <body onload="load()">

    	<!-- Static navbar -->
    	<nav class="navbar navbar-inverse navbar-static-top">
	        <div class="container">
	          	<div class="navbar-header">
	            	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	              		<span class="sr-only">Toggle navigation</span>
	              		<span class="icon-bar"></span>
	              		<span class="icon-bar"></span>
	              		<span class="icon-bar"></span>
	            	</button>
	            	<a class="navbar-brand" href="/">ParkingLegend.com</a>
	          	</div>
	          	<div id="navbar" class="navbar-collapse collapse">
	            	<ul class="nav navbar-nav">
		              	<li class="{{ set_active('faq') }}"><a href="/faq">{{Lang::get('site.nav_faq')}}</a></li>
		              	<li class="{{ set_active('contact') }}"><a href="/contact">{{Lang::get('site.nav_contact')}}</a></li>
		            </ul>
		            <ul class="nav navbar-nav navbar-right">
		            	<li class="dropdown">
						    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{!! get_current_lang_icon() !!} <b class="caret"></b></a>
						    <ul class="dropdown-menu">
						        @foreach (Config::get('app.locales') as $lang => $language)
						            @if ($lang != App::getLocale())
						                <li>
						                    <!--{!! link_to_route('lang.switch', $language, $lang) !!}-->
						                    {!! link_to_route_icon('lang.switch', $lang, $language) !!}
						                </li>
						            @endif
						        @endforeach
						    </ul>
						</li>
		            	@if(Auth::check())
		            		<li class="dropdown">
					          	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><strong>My Account</strong><span class="caret"></span></a>
					          	<ul class="dropdown-menu" role="menu">
					            	<li><a href="/settings">Account settings</a></li>
					            	<li><a href="/mybookings">Manage my Bookings</a></li>
					            	<li>{!!link_to('auth/logout', 'Logout')!!}</li>
					          	</ul>
					        </li>
		            	@else
		            		<!--<li>{{link_to('login', 'Login')}}</li>-->
		            		<li><a href="/auth/login">{{Lang::get('site.nav_login')}}</a></li>
		            		<li><a href="/auth/register">{{Lang::get('site.nav_register')}}</a></li>
		            	@endif
				    </ul>
	          	</div><!--/.nav-collapse -->
	        </div><!--/.container-fluid -->
	    </nav>