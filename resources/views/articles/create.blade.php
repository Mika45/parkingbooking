@extends('fulllayout')

@section('content')

<h1>Add a new Article</h1>

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

	{!! Form::open(['action' => 'ArticlesController@store', 'id' => 'search']) !!}
		@include('forms.article')
	{!! Form::close() !!}
</div>
@stop