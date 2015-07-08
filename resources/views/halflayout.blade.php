@include('common.header')

	<div class="container">

	    <div class="row">

	        <div class="col-md-6">
        		@yield('content-left')
	        </div>
	        
	        <div class="col-md-6">
        		@yield('content-right')
	        </div>

	    </div>

    </div>

@include('common.footer')