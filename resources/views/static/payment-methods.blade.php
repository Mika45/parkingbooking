@extends('layout')

@section('title')
    {{Lang::get('site.page_payment')}}
@stop

@section('sidebar')
	<h1>&nbsp;</h1>
	<img src="/img/online.png"/>
@stop

@section('content')

	<h1>{{Lang::get('content.payment_methods_heading')}}</h1>
	<p align="left">
		{!! Lang::get('content.payment_methods_content') !!}
	</p>

@stop