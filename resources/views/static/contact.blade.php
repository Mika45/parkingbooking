@extends('layout')

@section('title')
    {{Lang::get('site.page_contact')}}
@stop

@section('sidebar')
	<h1>&nbsp;</h1>
	<img src="/img/contact-us.png"/>
@stop

@section('content')

	<h1>{{Lang::get('content.contact_heading')}}</h1>
	<p align="left">
		{!! Lang::get('content.contact_content') !!}
	</p>

@stop