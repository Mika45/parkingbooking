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
					<table id="parkings" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><small>Parking name</small></th>
								<th><small>Status</small></th>
								<th><small>Rate type</small></th>
								<th><small>Slots</small></th>
								<th><small>24 Hour</small></th>
								<th><small>Phone</small></th>
								<th><small>E-mail</small></th>
								<th><small>Actions</small></th>
							</tr>
						</thead>
						<tbody>
					  		@foreach ($parkings as $parking)
							<tr>
								<td><small><a href="/parking/{{ $parking->parking_id }}" target="_blank" title="View parking page">{{ $parking->parking_name }}</a></small></td>
								<td><small>{{ $parking->status }}</small></td>
								<td><small>{{ $parking->rate_type }}</small></td>
								<td><small>{{ $parking->slots }}</small></td>
								<td><small>{{ $parking->allday }}</small></td>
								<td><small>{{ $parking->phone1 }}</small></td>
								<td><small>{{ $parking->email }}</small></td>
								<td>
									<a href="/admin/parking/{{ $parking->parking_id }}/edit" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Parking"><i class="fa fa-fw fa-edit"></i></div></a>
									@if ( $parking->allday == 'No')
										<a href="/admin/parking/{{ $parking->parking_id }}/schedule" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Schedule"><i class="fa fa-fw fa-calendar"></i></a>
									@else
										<a href="/admin/parking/{{ $parking->parking_id }}/schedule" class="btn btn-warning disabled btn-xs"><i class="fa fa-fw fa-calendar"></i></a>
									@endif
									<a href="/admin/parking/{{ $parking->parking_id }}/products" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Services"><i class="fa fa-fw fa-shopping-cart"></i></a>
									<a href="/admin/translations/parking/{{ $parking->parking_id }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Translations"><i class="fa fa-fw fa-globe"></i></a>
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

      	$('[data-toggle="tooltip"]').tooltip();

          $('#parkings').DataTable({
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