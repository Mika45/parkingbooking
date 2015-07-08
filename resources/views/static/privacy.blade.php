@extends('layout')

@section('content')

	<h1>{{Lang::get('content.privacy_heading')}}</h1>
	<p align="left">
		{!!Lang::get('content.privacy_content')!!}
	</p>
@stop