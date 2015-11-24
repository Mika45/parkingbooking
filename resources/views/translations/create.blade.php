@extends('fulllayout')


@section('content')

	@if ( $type == 'parking' )
		<h1>Add a new Parking Translation</h1>
		<h4>for {{ $parking->parking_name }}</h4>
	@elseif ( $type == 'location' )
		<h1>Add a new Location Translation</h1>
		<h4>for {{ $location->name }}</h4>
	@elseif ( $type == 'tag' )
		<h1>Add a new Tag Translation</h1>
		<h4>for {{ $tag->name }}</h4>
	@elseif ( $type == 'article' )
		<h1>Add a new Article Translation</h1>
		<h4>for {{ $article->title }}</h4>
	@elseif ( $type == 'product' )
		<h1>Add a new Product Translation</h1>
		<h4>for {{ $product->name }}</h4>
	@endif

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

	{!! Form::open(['action' => 'TranslationsController@store', 'id' => 'createtrans']) !!}
		@include('forms.translation')
	{!! Form::close() !!}
</div>
@stop
