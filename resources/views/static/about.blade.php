@extends('layout')

@section('title')
    {{Lang::get('site.page_about')}}
@stop

@section('sidebar')
	<h1>&nbsp;</h1>
	<img src="/img/about.png"/>
@stop

@section('content')

	<h1>{{Lang::get('content.about_heading')}}</h1>
	<p>
		{!!Lang::get('content.about_content')!!}
	</p>
@stop