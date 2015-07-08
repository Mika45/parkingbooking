@extends('layout57')

@section('content-left')

	<div class="well well-yellow">
		<legend>
			<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
          	<span class="glyphicon-class">{{Lang::get('site.search_heading')}}</span>
		</legend>
		<!--{!! Form::open(['url' => '/results', 'id' => 'search']) !!}-->
		{!! Form::open(['action' => 'PagesController@search', 'id' => 'search', 'class' => 'form-horizontal']) !!}
			@include('forms.search')
		{!! Form::close() !!}
	</div>

@stop

@section('content-right')
	
	@if (Session::has('message'))
		<div class="alert alert-dismissible alert-success">
		  	<button type="button" class="close" data-dismiss="alert">×</button>
		  	{!! Session::get('message') !!}
		</div>
	@endif

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
            <p>Make your Booking</p>
          </div>
	    </div>
		
	    <div class="item active">
	      <img src="/img/save-money.jpg" alt="savemoney">
		  <div class="carousel-caption">
            <p>Save Money</p>
          </div>
	    </div>

	    <div class="item">
	      <img src="/img/secure-parking.jpg" alt="secureparking">
		  <div class="carousel-caption">
            <p>Secure Parking</p>
          </div>
	    </div>

	    <div class="item">
	      <img src="/img/secure-payments.jpg" alt="securepayment">
		  <div class="carousel-caption">
            <p>Secure Payment Online</p>
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