@extends('booklayout')

@section('content')

	<h1>Edit Tag</h1>

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
	
		{!! Form::model($tag, ['method' => 'PATCH', 'action' => ['TagsController@update', $tag->tag_id], 'id' => 'edittag']) !!}
			@include('forms.tag')
		{!! Form::close() !!}
	</div>

@stop