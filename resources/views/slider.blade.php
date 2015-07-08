@extends('layout')

@section('sidebar')

	<div class="well well-sm">
		The form is here
	</div>

@stop

@section('content')

	
		
	  		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
			    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			    <li data-target="#myCarousel" data-slide-to="1"></li>
			    <li data-target="#myCarousel" data-slide-to="2"></li>
			    <li data-target="#myCarousel" data-slide-to="3"></li>
			  </ol>

			  <!-- Wrapper for slides -->
			  <div class="carousel-inner" role="listbox">
			    <div class="item">
			      <img src="/img/booking.jpg" alt="booking">
				  <div class="carousel-caption">
                    <h1>Make your Booking</h1>
                  </div>
			    </div>
				
			    <div class="item active">
			      <img src="/img/save-money.jpg" alt="savemoney">
				  <div class="carousel-caption">
                    <h1>Save Money</h1>
                  </div>
			    </div>

			    <div class="item">
			      <img src="/img/secure-parking.jpg" alt="secureparking">
				  <div class="carousel-caption">
                    <h1>Secure Parking</h1>
                  </div>
			    </div>

			    <div class="item">
			      <img src="/img/secure-payments.jpg" alt="securepayment">
				  <div class="carousel-caption">
                    <h1>Secure Payment Online</h1>
                  </div>
			    </div>
			  </div>

			  <!-- Left and right controls -->
			  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>
			</div>

	  	
	

	

@stop