@extends('templates.admin')

@section('content')

<div class="row">
   <div class="col-xs-12">
     	<div class="box">
			<div class="box-header">
				@if (isset($box_title))<h3 class="box-title">{{ $box_title or null }}</h3><br/>@endif
         	<a href="/admin/schedules/{{ $id }}/create" class="btn btn-warning btn-xs">Add a Schedule entry</a>
       	</div><!-- /.box-header -->
			<div class="box-body">
				<table id="partners" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th><small>Day</small></th>
							<th><small>From Hour</small></th>
							<th><small>To Hour</small></th>
							<th><small>Type</small></th>
							<th><small>Actions</small></th>
						</tr>
					</thead>
					<tbody>
				  		@foreach ($times as $time)
						<tr>
							<td><small>{{ $time->day }}</small></td>
							<td><small>{{ $time->from_hour }}</small></td>
							<td><small>{{ $time->to_hour }}</small></td>
							<td><small>{{ $time->type }}</small></td>
							<td><a href="/admin/schedules/{{ $time->schedule_id }}/edit" class="btn btn-primary btn-xs">Edit</a>
								 <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#basicModal{{$time->schedule_id}}">Delete</a></td>

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
			</div>
		</div>
	</div>
</div>

@stop

@section('plugins')
	<!-- Datatabels -->
   {!! HTML::script('js/admin/jquery.dataTables.min.js') !!}
	{!! HTML::script('js/admin/dataTables.bootstrap.min.js') !!}
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/bs/dt-1.10.10/datatables.min.css"/>
    @parent
@stop

@section('javascript')
    <script>
      $(document).ready(function() {
      	$('[data-toggle="tooltip"]').tooltip();
         $('#partners').DataTable({
           "paging": true,
           "lengthChange": true,
           "searching": true,
           "ordering": true,
           "info": true,
           "autoWidth": false
         });
      } );
    </script>
    @parent
@stop