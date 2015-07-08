@extends('fulllayout')

@section('content')

	<h1>Edit Location</h1>

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
	
		{!! Form::model($location, ['method' => 'PATCH', 'action' => ['LocationsController@update', $location->location_id], 'id' => 'search']) !!}
			@include('forms.location')
		{!! Form::close() !!}
	</div>

@stop