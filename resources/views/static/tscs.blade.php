@extends('fulllayout')

@section('content')

	<h1>{{Lang::get('content.terms_heading')}}</h1>
	<p align="justify">
		<small>
		{!!Lang::get('content.terms_content')!!}
		</small>
	</p>
@stop