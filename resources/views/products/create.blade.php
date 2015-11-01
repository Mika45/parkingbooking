@extends('fulllayout')

@section('content')

<h1>Add a new Product</h1>
<h4>for {{ $parking_name }}</h4>

<div class="well">
	
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			{{Lang::get('validation.errors_heading')}}<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	{!! Form::open(['action' => 'ProductsController@store', 'id' => 'createproduct']) !!}
		@include('forms.product')
	{!! Form::close() !!}
</div>
@stop