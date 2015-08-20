@extends('layout')

@section('title')
    {{Lang::get('site.page_affiliates')}}
@stop

@section('sidebar')
	<h1>&nbsp;</h1>
	<img src="/img/profit.png"/>
@stop

@section('content')

	<h1>{{Lang::get('content.affiliates_heading')}}</h1>
	<p align="left">
		{!! Lang::get('content.affiliates_content') !!}
	</p>

@stop