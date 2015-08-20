@extends('layout')

@section('title')
    {{Lang::get('site.page_about')}}
@stop

@section('content')

	<h1>{{Lang::get('content.about_heading')}}</h1>
	<p>
		{!!Lang::get('content.about_content')!!}
	</p>
@stop