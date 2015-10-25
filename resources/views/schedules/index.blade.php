@extends('fulllayout')

@section('content')

	<h1>Parking Schedule</h1>

	<table class="table table-condensed table-striped table-hover">
		<thead>
			<tr>
			  <th><small>Day</small></th>
			  <th><small>From Hour</small></th>
			  <th><small>To Hour</small></th>
			  <th><small>Type</small></th>
			  <th></th>
			  <th></th>
			</tr>
		</thead>
		<tbody>
	  	@foreach ($times as $time)
			<tr>
				<td><small>{{ $time->day }}</small></td>
				<td><small>{{ $time->from_hour }}</small></td>
				<td><small>{{ $time->to_hour }}</small></td>
				<td><small>{{ $time->type }}</small></td>
				<td><a href="/schedules/{{ $time->schedule_id }}/edit" class="btn btn-primary btn-xs">Edit</a></td>
				<td><a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#basicModal{{$time->schedule_id}}">Delete</a></td>

				<div class="modal fade" id="basicModal{{$time->schedule_id}}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
				    <div class="modal-dialog">
				        <div class="modal-content">
				            <div class="modal-header">
					            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					            <h4 class="modal-title" id="myModalLabel">Delete</h4>
				            </div>
				            <div class="modal-body">
				                <p>Are you sure you want to delete this schedule entry?</p>
				            </div>
				            <div class="modal-footer">
				                
				                {!! Form::open(['method' => 'DELETE', 'route' => ['schedules.destroy', $time->schedule_id]]) !!}
				                		<button type="button" class="btn btn-default" data-dismiss="modal">No</button>	
				                		{!! Form::submit('Yes', ['class' => 'btn btn-default']) !!}
				                	
				                {!! Form::close() !!}
				        	</div>
				    </div>
				  </div>
				</div>

			</tr>
		@endforeach
		</tbody>
	</table>

	<fieldset>
		<div class="form-group">
			<div class="col-lg-10"><a href="/schedules/{{ $id }}/create" class="btn btn-warning btn-xs">Add Schedule entry</a></div>
			<div class="col-lg-2"></div>
		</div>
	</fieldset>

@stop