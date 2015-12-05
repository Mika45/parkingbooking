@include('common.header')

	<div class="container">

	    <div class="row">

	        <div class="col-md-12">
	        	@yield('content-top')
	        </div>

	        <div class="col-md-5">
        		@yield('content-left')
	        </div>
	        
	        <div class="col-md-7">
        		@yield('content-right')
	        </div>

	    </div>

	    <div class="row">

	    	<div class="col-md-12">
        		@yield('content-bottom')
	        </div>

	    </div>

    </div>

@include('common.footer')