@extends('booklayout')

@section('content')

	<h1>Products</h1>

	<table class="table table-condensed table-striped table-hover">
		<thead>
			<tr>
			  <th><small>#</small></th>
			  <th><small>Name</small></th>
			  <th><small>Price</small></th>
			  <th></th>
			  <th></th>
			</tr>
		</thead>
		<tbody>
	  	@foreach ($products as $product)
			<tr>
				<td></td>
				<td><small>{{ $product->name }}</small></td>
				<td><small>{{ $product->price }}</small></td>
				<td><a href="/products/{{ $product->product_id }}/edit" class="btn btn-primary btn-xs">Edit</a></td>
				<td><a href="/translations/product/{{ $product->product_id }}" class="btn btn-success btn-xs">Edit Translation</a></td>
			</tr>
		@endforeach
		</tbody>
	</table>

	<?php echo $products->render(); ?>

@stop