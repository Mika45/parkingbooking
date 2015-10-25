@extends('fulllayout')

@section('content')

<h1>Add new Schedule entry</h1>

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

	{!! Form::open(['action' => 'ParkingScheduleController@store', 'class' => 'form-horizontal', 'id' => 'schedulestore']) !!}
		@include('forms.schedule')
	{!! Form::close() !!}
</div>
@stop
