@extends('booklayout')

@section('content')

<h1>Edit rates for {{ $parking->parking_name }}</h1>

<table class="table table-condensed table-striped table-hover">
	<thead>
		<tr>
			@if ( $parking->rate_type == 'D' )
				<th><small>Day</small></th>
			@elseif ( $parking->rate_type == 'H' )
				<th><small>Hours</small></th>
			@endif
			<th><small>Price</small></th>
			<th><small>Discount</small></th>
			<th><small>Free minutes</small></th>
			<th><small></small></th>
		</tr>
	</thead>
	<tbody>
  	@foreach ($rates as $rate)
		<tr>
			@if ( $parking->rate_type == 'D' )
				<td><small>{{ $rate->day }}</small></td>
			@elseif ( $parking->rate_type == 'H' )
				<td><small>{{ $rate->hours }}</small></td>
			@endif
			<td><small>{{ $rate->price }}</small></td>
			<td><small>{{ $rate->discount }}</small></td>
			<td><small>{{ $rate->free_mins }}</small></td>
			<td><a href="/rates/{{ $rate->rate_id }}/edit" class="btn btn-primary btn-xs">Edit</a></td>
		</tr>
	@endforeach
	</tbody>
</table>

<fieldset>
	<div class="form-group">
		<div class="col-lg-10"><a href="/rates/{{ $parking->parking_id }}/create" class="btn btn-warning btn-xs">Add Rate</a></div>
		<div class="col-lg-2"></div>
	</div>
</fieldset>

@stop