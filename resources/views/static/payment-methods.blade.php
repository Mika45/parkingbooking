@extends('layout')

@section('sidebar')
	
@stop

@section('content')

	<h1>{{Lang::get('content.payment_methods_heading')}}</h1>
	<p align="left">
		{!! Lang::get('content.payment_methods_content') !!}
	</p>

@stop