@extends('layout')

@section('content')

	<h1>{{Lang::get('content.about_heading')}}</h1>
	<p>
		{!!Lang::get('content.about_content')!!}
	</p>
@stop