@extends('layout')

@section('sidebar')

	<div class="well well-sm">
		<legend>
			<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
          	<span class="glyphicon-class">{{Lang::get('site.search_heading')}}</span>
		</legend>
		<!--{!! Form::open(['url' => '/results', 'id' => 'search']) !!}-->
		{!! Form::open(['action' => 'PagesController@search', 'id' => 'search']) !!}
			@include('forms.search_narrow')
		{!! Form::close() !!}
	</div>

@stop

@section('content')

	<h1>{{Lang::get('site.back_book_heading')}}</h1>
	
	@if ( session()->has('message') )
		<div class="alert alert-dismissible alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
		  	{{ session()->get('message') }}
		</div>
	@endif

	<table class="table table-hover">
		<thead>
			<tr>
			  <th><small>#</small></th>
			  <th><small>{{Lang::get('site.amend_parking')}}</small></th>
			  <th><small>{{Lang::get('site.back_book_booked_at')}}</small></th>
			  <th><small>{{Lang::get('site.back_book_checkin')}}</small></th>
			  <th><small>{{Lang::get('site.back_book_checkout')}}</small></th>
			  <th><small>{{Lang::get('site.back_book_price')}}</small></th>
			  <th><small>{{Lang::get('site.back_book_car_reg')}}</small></th>
			  <th></th>
			  <th></th>
			</tr>
		</thead>
		<tbody>
	  	@foreach ($bookings as $booking)
			<tr>
				<td></td>
				<td><small>{{ $booking->parking_name }}</small></td>
				<td><small>{{ $booking->booked_at }}</small></td>
				<td><small>{{ $booking->checkin }}</small></td>
				<td><small>{{ $booking->checkout }}</small></td>
				<td><small>{{ $booking->price }}</small></td>
				<td><small>{{ $booking->car_reg }}</small></td>
				<td><a href="/mybookings/{{ $booking->booking_id }}" target="_blank" class="btn btn-primary btn-sm">{{Lang::get('site.back_book_conf_btn')}}</a></td>
				<td><a href="/mybookings/{{ $booking->booking_id }}/amend" class="btn btn-danger btn-sm">{{Lang::get('site.back_book_amend_btn')}}</a></td>
			</tr>
		@endforeach
		</tbody>
	</table>

@stop