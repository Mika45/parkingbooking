@extends('templates.admin')

@section('content')

<div class="row">
   <div class="col-xs-12">
     	<div class="box">
			<div class="box-header">
				@if (isset($box_title))<h3 class="box-title">{{ $box_title or null }}</h3><br/>@endif
         	<a href="/admin/products/{{ $parking_id }}/create" class="btn btn-warning btn-xs">Add Product</a>
       	</div><!-- /.box-header -->
			<div class="box-body">
				<table id="partners" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th><small>Name</small></th>
							<th><small>Price</small></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
				  		@foreach ($products as $product)
						<tr>
							<td><small>{{ $product->name }}</small></td>
							<td><small>{{ $product->price }}</small></td>
							<td><a href="/admin/products/{{ $product->product_id }}/edit" class="btn btn-primary btn-xs">Edit</a>
								 <a href="/admin/translations/product/{{ $product->product_id }}" class="btn btn-success btn-xs">Edit Translation</a></td>
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