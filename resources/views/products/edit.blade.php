@extends('fulllayout')

@section('content')

	<h1>Edit Product</h1>

	<div class="well">
	
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				There were some problems with your input.<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
	
		{!! Form::model($product, ['method' => 'PATCH', 'action' => ['ProductsController@update', $product->product_id], 'id' => 'editproduct']) !!}
			@include('forms.product')
		{!! Form::close() !!}
	</div>

@stop