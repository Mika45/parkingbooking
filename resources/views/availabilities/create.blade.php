@extends('booklayout')


@section('content')

<h1>Create Parking availability</h1>

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

	{!! Form::open(['action' => 'AvailabilitiesController@store', 'id' => 'search']) !!}
		@include('forms.availability')
	{!! Form::close() !!}
</div>
@stop