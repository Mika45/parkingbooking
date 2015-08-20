@extends('fulllayout')

@section('title')
    {{Lang::get('site.page_privacy')}}
@stop

@section('content')

	<h1>{{Lang::get('content.privacy_heading')}}</h1>
	<p align="justify">
		<small>
		{!!Lang::get('content.privacy_content')!!}
		</small>
	</p>
@stop