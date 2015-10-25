@extends('fulllayout')

@section('content')

<h1>Edit Schedule entry</h1>

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

	{!! Form::model($schedule, ['method' => 'PATCH', 'action' => ['ParkingScheduleController@update', $schedule->schedule_id], 'class' => 'form-horizontal', 'id' => 'editschedule']) !!}
		@include('forms.schedule')
	{!! Form::close() !!}
</div>
@stop