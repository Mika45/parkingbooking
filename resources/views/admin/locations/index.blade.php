@extends('templates.admin')

@section('content')

	<div class="row">
      <div class="col-xs-12">
        	<div class="box">
				@if (isset($box_title))
				<div class="box-header">
            	<h3 class="box-title">{{ $box_title or null }}</h3>
          	</div><!-- /.box-header -->
          	@endif
				<div class="box-body">
					<table id="locations" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><small>Location</small></th>
								<th><small>Status</small></th>
								<th><small>Parent location</small></th>
								<th><small>Latitude</small></th>
								<th><small>Longtitude</small></th>
								<th><small>Actions</small></th>
							</tr>
						</thead>
						<tbody>
					  		@foreach ($locations as $location)
							<tr>
								<td><small>{{ $location->name }}</small></td>
								<td><small>{{ $location->status }}</small></td>
								<td><small>{{ $location->parent_name }}</small></td>
								<td><small>{{ $location->lat }}</small></td>
								<td><small>{{ $location->lng }}</small></td>
								<td>
									<a href="/admin/locations/{{ $location->location_id }}/edit" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Location"><i class="fa fa-fw fa-edit"></i></a>
									<a href="/admin/translations/location/{{ $location->location_id }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Translations"><i class="fa fa-fw fa-globe"></i></a>
								</td>
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
          $('#locations').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
          });
      } );
    </script>
    @parent
@stop