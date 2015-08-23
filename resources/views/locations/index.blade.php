@extends('fulllayout')

@section('content')

	<h1>Locations</h1>

	<table class="table table-condensed table-striped table-hover">
		<thead>
			<tr>
			  <th><small>#</small></th>
			  <th><small>Location</small></th>
			  <th><small>Status</small></th>
			  <th><small>Parent location</small></th>
			  <th><small>Latitude</small></th>
			  <th><small>Longtitude</small></th>
			  <th></th>
			  <th></th>
			  <th><small>Translation</small></th>
			  {{--<th></th>--}}
			</tr>
		</thead>
		<tbody>
	  	@foreach ($locations as $location)
			<tr>
				<td></td>
				<td><small>{{ $location->name }}</small></td>
				<td><small>{{ $location->status }}</small></td>
				<td><small>{{ $location->parent_name }}</small></td>
				<td><small>{{ $location->lat }}</small></td>
				<td><small>{{ $location->lng }}</small></td>
				<td><a href="/locations/{{ $location->location_id }}/edit" class="btn btn-primary btn-xs">Edit</a></td>
				<td>  {{-- <a href="#" class="btn btn-danger btn-xs">Delete</a> --}} </td>
				<td><a href="/translations/location/{{ $location->location_id }}" class="btn btn-success btn-xs">Edit</a></td>
				{{--<td><a href="/locations/{{ $location->location_id }}" target="_blank" class="btn btn-warning btn-xs">View</a></td>--}}
			</tr>
		@endforeach
		</tbody>
	</table>

	<?php echo $locations->render(); ?>

@stop