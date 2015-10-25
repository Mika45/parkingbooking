@extends('fulllayout')

@section('content')

	<h1>Parkings</h1>

	<table class="table table-condensed table-striped table-hover">
		<thead>
			<tr>
			  <th><small>#</small></th>
			  <th><small>Parking name</small></th>
			  <th><small>Status</small></th>
			  <th><small>Rate type</small></th>
			  <th><small>Slots</small></th>
			  <th><small>24 Hour</small></th>
			  <th><small>Phone</small></th>
			  <th><small>E-mail</small></th>
			  <th><small>Created at</small></th>
			  <th><small></small></th>
			  <th><small>Rate</small></th>
			  <th><small>Schedule</small></th>
			  <th><small>Translation</small></th>
			  
			</tr>
		</thead>
		<tbody>
	  	@foreach ($parkings as $parking)
			<tr>
				<td></td>
				<td><small><a href="/parking/{{ $parking->parking_id }}" target="_blank" title="View parking page">{{ $parking->parking_name }}</a></small></td>
				<td><small>{{ $parking->status }}</small></td>
				<td><small>{{ $parking->rate_type }}</small></td>
				<td><small>{{ $parking->slots }}</small></td>
				<td><small>{{ $parking->allday }}</small></td>
				<td><small>{{ $parking->phone1 }}</small></td>
				<td><small>{{ $parking->email }}</small></td>
				<td><small>{{ $parking->created_at }}</small></td>
				<td><a href="/parking/{{ $parking->parking_id }}/edit" class="btn btn-primary btn-xs">Edit</a></td>
				<td>
					@if ( $rates[$parking->parking_id]['hasRate'] == 0)
						<a href="/rates/{{ $parking->parking_id }}/create" class="btn btn-warning btn-xs">Create</a> 
						<a href="/parking/{{ $parking->parking_id }}/rates" class="btn btn-warning disabled btn-xs">Edit</a>
					@else
						<a href="/rates/{{ $parking->parking_id }}/create" class="btn btn-warning disabled btn-xs">Create</a> 
						<a href="/parking/{{ $parking->parking_id }}/rates" class="btn btn-warning btn-xs">Edit</a>
					@endif
				</td>

				<td>
					@if ( $parking->allday == 'No')
						<a href="/parking/{{ $parking->parking_id }}/schedule" class="btn btn-info btn-xs">Edit</a>
					@else
						<a href="/parking/{{ $parking->parking_id }}/schedule" class="btn btn-info disabled btn-xs">Edit</a>
					@endif
				</td>
				<td><a href="/translations/parking/{{ $parking->parking_id }}" class="btn btn-success btn-xs">Edit</a></td>
				{{-- <td><a href="/translations/parking/{{ $parking->parking_id }}/create" class="btn btn-primary btn-xs">Create</a></td> --}}
				
			</tr>
		@endforeach
		</tbody>
	</table>

	<?php echo $parkings->render(); ?>

@stop