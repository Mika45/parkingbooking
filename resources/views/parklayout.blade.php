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
					            	<li><a href="#">Manage my Bookings</a></li>
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

    	<div class="container">

		    <div class="row">
		    	<div class="col-md-3">
		            @yield('sidebar-left')
		        </div>
		        <div class="col-md-6">
	        		@yield('content')
		        </div>
		        <div class="col-md-3">
	        		@yield('sidebar-right')
		        </div>
		    </div>

        </div>

		<div id="footer" class="container-fluid">
        	<div class="container">
	        	<footer>
			    	<div class="row">
			        	<div class="col-lg-12">
			            	<ul class="list-unstyled">
			              		<li><a href="/about">{{Lang::get('site.nav_about')}}</a></li>
			              		<li><a href="/tscs">{{Lang::get('site.nav_tscs')}}</a></li>
			              		<li><a href="/privacy">{{Lang::get('site.nav_privacy')}}</a></li>
			              		<li><a href="/payment">{{Lang::get('site.nav_payment')}}</a></li>
			            	</ul>
			            	<p>ParkingLegend.com &copy; All rights reserved.
			          	</div>
			        </div>
		    	</footer>
	    	</div>
	    </div>

    </body>
</html>