@extends('fulllayout')

@section('content')

	<h1>Edit Field</h1>

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
	
		{!! Form::model($field, ['method' => 'PATCH', 'action' => ['FieldsController@update', $field->field_id], 'id' => 'editfield']) !!}
			@include('forms.field')
		{!! Form::close() !!}
	</div>

@stop