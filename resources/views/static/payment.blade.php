@extends('layout')

@section('content')

	<h1>{{Lang::get('site.pay_success_head')}}</h1>
	<p>
		{!! Lang::get('site.pay_success_body') !!}
	</p>
@stop