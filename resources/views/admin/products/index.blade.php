@extends('templates.admin')

@section('content')

<div class="row">
   <div class="col-xs-12">
     	<div class="box">
			<div class="box-header">
				@if (isset($box_title))<h3 class="box-title">{{ $box_title or null }}</h3><br/>@endif
         	<a href="/admin/products/{{ $parking_id }}/create" class="btn btn-warning btn-xs">Add Service</a>
       	</div><!-- /.box-header -->
			<div class="box-body">
				@if (Session::has('flash_message'))
				<div class="alert alert-danger alert-dismissable">
            	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              	<h4><i class="icon fa fa-ban"></i> Error!</h4>
              	{{ Session::get('flash_message') }}
            </div>
            @endif
				<table id="partners" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th><small>Name</small></th>
							<th><small>Price</small></th>
							<th><small>Actions</small></th>
						</tr>
					</thead>
					<tbody>
				  		@foreach ($products as $product)
						<tr>
							<td><small>{{ $product->name }}</small></td>
							<td><small>{{ $product->price }}</small></td>
							<td>
								<a href="/admin/products/{{ $product->product_id }}/edit" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Service"><i class="fa fa-fw fa-edit"></i></a>
								<a href="/admin/translations/product/{{ $product->product_id }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Translations"><i class="fa fa-fw fa-globe"></i></a>
								<span data-toggle="modal" data-target="#basicModal{{$product->product_id}}">
									<a href="#" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete Service"><i class="fa fa-fw fa-remove"></i></a>
								</span>
							</td>

							<div class="modal fade" id="basicModal{{$product->product_id}}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
							    <div class="modal-dialog">
							        <div class="modal-content">
							            <div class="modal-header">
								            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								            <h4 class="modal-title" id="myModalLabel">Delete Service</h4>
							            </div>
							            <div class="modal-body">
							                <p>Are you sure you want to delete this parking service?</p>
							            </div>
							            <div class="modal-footer">
							                
							                {!! Form::open(['method' => 'DELETE', 'route' => ['admin.products.destroy', $product->product_id]]) !!}
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