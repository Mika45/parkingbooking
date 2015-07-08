@extends('fulllayout')

@section('content')

	<h1>Edit Translation</h1>

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
	
		{!! Form::model($translation, ['method' => 'PATCH', 'action' => ['TranslationsController@update', $translation->translation_id], 'id' => 'edittrans']) !!}
			@include('forms.translation')
		{!! Form::close() !!}
	</div>

@stop