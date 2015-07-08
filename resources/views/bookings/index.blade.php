@extends('fulllayout')

@section('content')
	
	<h1>Bookings</h1>

	<table class="table table-condensed table-striped table-hover">
		<thead>
			<tr>
			  	<th><small>Booking reference</small></th>
			  	<th><small>Parking name</small></th>
			  	<th><small>Drop-Off date/time</small></th>
			  	<th><small>Pick-Up date/time</small></th>
			  	<th><small>Price</small></th>
			  	<th><small>Name</small></th>
			  	<th><small>Mobile</small></th>
			  	<th><small>E-mail</small></th>
			  	<th><small>Booked at</small></th>
			</tr>
		</thead>
		<tbody>
	  	@foreach ($bookings as $booking)
			<tr>
				<td><small><b>{{ $booking->booking_ref }}</b></small></td>
				<td><small>{{ $booking->parking_name }}</small></td>
				<td><small>{{ $booking->checkin }}</small></td>
				<td><small>{{ $booking->checkout }}</small></td>
				<td><small>{{ $booking->price }}</small></td>
				<td><small>{{ $booking->firstname }} {{ $booking->lastname }}</small></td>
				<td><small>{{ $booking->mobile }}</small></td>
				<td><small>{{ $booking->email }}</small></td>
				<td><small>{{ $booking->created_at }}</small></td>
			</tr>
		@endforeach
		</tbody>
	</table>

	<?php echo $bookings->render(); ?>

@stop