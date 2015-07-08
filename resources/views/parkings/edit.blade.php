@extends('fulllayout')

@section('content')

	<h1>Edit Parking</h1>

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
	
		{!! Form::model($parking, ['method' => 'PATCH', 'action' => ['ParkingsController@update', $parking->parking_id], 'id' => 'search']) !!}
			@include('forms.parking')
		{!! Form::close() !!}
	</div>

@stop