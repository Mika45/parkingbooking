@extends('booklayout')

@section('content')

<h1>Add a new Tag</h1>

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

	{!! Form::open(['action' => 'TagsController@store', 'id' => 'createtag', 'files' => true]) !!}
		@include('forms.tag')
	{!! Form::close() !!}
</div>
@stop