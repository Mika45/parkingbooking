@extends('fulllayout')

@section('content')

	<h1>Edit Article</h1>

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
	
		{!! Form::model($article, ['method' => 'PATCH', 'action' => ['ArticlesController@update', $article->article_id], 'id' => 'search']) !!}
			@include('forms.article')
		{!! Form::close() !!}
	</div>

@stop