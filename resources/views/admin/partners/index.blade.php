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
				<table id="partners" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th><small>First name</small></th>
							<th><small>Last name</small></th>
							<th><small>E-mail</small></th>
							<th><small>Landline</small></th>
							<th><small>Mobile</small></th>
							<th><small>Referrer URL</small></th>
							<th><small>Tracking Link</small></th>
							<th><small>User</small></th>
							<th><small>Actions</small></th>
						</tr>
					</thead>
					<tbody>
				  		@foreach ($affiliates as $affiliate)
						<tr>
							<td><small>{{ $affiliate->firstname }}</small></td>
							<td><small>{{ $affiliate->lastname }}</small></td>
							<td><small>{{ $affiliate->email }}</small></td>
							<td><small>{{ $affiliate->landline }}</small></td>
							<td><small>{{ $affiliate->mobile }}</small></td>
							<td><small>
								{{ $affiliate->referrer }} 
							</small></td>	
							<td><small>
								@if($affiliate->referrer)
									/noaf={{$affiliate->affiliate_id}}&ref={{$affiliate->referrer}}
								@endif
							</small></td>
							<td><small>{{ $affiliate->user_email }}</small></td>
							<td>
								<a href="/admin/partners/{{ $affiliate->affiliate_id }}/edit" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Affiliate"><i class="fa fa-fw fa-edit"></i></a>
								<a href="#" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Remove Affiliate"><i class="fa fa-fw fa-remove"></i></a>
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