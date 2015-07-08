@extends('booklayout')

@section('sidebar')

	Optional

@stop

@section('content')

	@if(Auth::check())
		<h1>{{ Lang::get('site.nav_settings') }}</h1>
		<div class="well bs-component">
			{!! Form::model($user, ['class' => 'form-horizontal']) !!}
				@include('forms.user')
			{!! Form::close() !!}
		</div>

	@endif

@stop