@include('common.header')

	<div class="container">

	    <div class="row">
	    	<div class="col-md-3">
	            @yield('sidebar')
	        </div>
	        <div class="col-md-9">
        		@yield('content')
	        </div>
	    </div>

    </div>

@include('common.footer')