@include('common.header')

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

@include('common.footer')