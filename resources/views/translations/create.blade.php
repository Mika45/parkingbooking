@extends('fulllayout')


@section('content')

	@if ( $type == 'parking' )
		<h1>Add a new Parking Translation for {{ $parking->parking_name }}</h1>
	@elseif ( $type == 'location' )
		<h1>Add a new Location Translation for {{ $location->name }}</h1>
	@elseif ( $type == 'tag' )
		<h1>Add a new Tag Translation for {{ $tag->name }}</h1>
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
