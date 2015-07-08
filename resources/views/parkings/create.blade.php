@extends('fulllayout')


@section('content')

<h1>Add a new Parking</h1>

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

	{!! Form::open(['action' => 'ParkingsController@store', 'id' => 'search']) !!}
		@include('forms.parking')
	{!! Form::close() !!}
</div>
@stop
