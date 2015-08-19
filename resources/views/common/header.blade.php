<!doctype html>
<html>
	<head>
		<title>ParkingLegend.com @yield('title')</title>
		<meta name="google-site-verification" content="JRnT1QScbmi8ajN_F8ZzCAXr7gwQVbgj1-Ub5DbdVpk" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		{!! HTML::script('js/jquery-1.11.2.min.js') !!}

		{!! HTML::script('js/jquery-migrate-1.2.1.min.js') !!}
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
		{!! HTML::style('css/bootstrap-modal-carousel.min.css') !!}

		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		{!! HTML::style('css/bootstrap-social.css') !!}
		
		{!! HTML::style('css/magnific-popup.css') !!}
		{!! HTML::script('js/jquery.magnific-popup.js') !!}

		<style>
			.bs-glyphicons-list{padding-left:0;list-style:none}
			/*.bs-glyphicons li{float:left;width:25%;height:115px;padding:10px;font-size:10px;}*/
			/*.glyphicon-ok{margin-top:5px;margin-bottom:10px;font-size:24px}*/
		</style>

	</head>
    <body>

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
	            	<a class="navbar-brand" href="/{{App::getLocale()}}/">
			        	<img alt="Brand" src="/img/logo.png">
			      	</a>
	            	{{--<a class="navbar-brand" href="/">ParkingLegend.com</a>--}}
	          	</div>
	          	<div id="navbar" class="navbar-collapse collapse">
	            	<ul class="nav navbar-nav">
		              	<li class="{{ set_active('faq') }}"><a href="/{{App::getLocale()}}/faq">{{Lang::get('site.nav_faq')}}</a></li>
		              	<li class="{{ set_active('contact') }}"><a href="/{{App::getLocale()}}/contact">{{Lang::get('site.nav_contact')}}</a></li>
		            </ul>
		            <ul class="nav navbar-nav navbar-right">
		            	<li class="dropdown">
						    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{!! get_current_lang_icon() !!} <b class="caret"></b></a>
						    <ul class="dropdown-menu">
						        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
							        <li>
							            {!! link_to_route_icon($properties, $localeCode) !!}
							        </li>
							    @endforeach
						    </ul>
						</li>
		            	@if(Auth::check())

		            		@if(Auth::user()->is_admin == 'Y')
		            			<li class="dropdown">
						          	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><strong>Manage System</strong><span class="caret"></span></a>
						          	<ul class="dropdown-menu" role="menu">
						            	<li><a href="/parking/create">Add a new Parking</a></li>
						            	<li><a href="/parking">Parkings</a></li>
						            	<li><a href="/locations/create">Add a new Location</a></li>
						            	<li><a href="/locations">Locations</a></li>
						            	<li><a href="/tags/create">Add a new Tag</a></li>
						            	<li><a href="/tags">Tags</a></li>
						            	{{-- <li><a href="/fields/create">Add a new Field</a></li> --}}
						            	{{-- <li><a href="/fields">Fields</a></li> --}}
						            	<li><a href="/bookings">Bookings</a></li>
						            	<li><a href="/articles/create">Add a new Article</a></li>
						            	<li><a href="/articles">Articles</a></li>
						          	</ul>
						        </li>
						    @endif

		            		<li class="dropdown">
					          	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><strong>{{Lang::get('site.nav_account')}}</strong><span class="caret"></span></a>
					          	<ul class="dropdown-menu" role="menu">
					            	<li><a href="/settings">{{Lang::get('site.nav_settings')}}</a></li>
					            	<li><a href="/mybookings">{{Lang::get('site.nav_bookings')}}</a></li>
					            	<li>{!!link_to('auth/logout', Lang::get('site.nav_logout'))!!}</li>
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