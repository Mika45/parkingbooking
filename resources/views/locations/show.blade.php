@extends('layout57')

@section('sidebar-left')

	<h2>Ads here</h2>
	<hr/>

@stop

@section('content-left')

	<table>
		<tr>
			<td width="85%"><h1>{!! $translations['name'] or $location->name !!}</h1></td>
		</tr>
	</table>

	<div class="well well-yellow">
		<legend>
			<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
          	<span class="glyphicon-class">{{Lang::get('site.search_heading')}}</span>
		</legend>
		{!! Form::open(['action' => 'PagesController@search', 'id' => 'search', 'class' => 'form-horizontal']) !!}
			@include('forms.search')
		{!! Form::close() !!}
	</div>

@stop

@section('content-right')
	<h1>&nbsp;</h1>

	@if (isset($location->lat) && isset($location->lng))
		{!!$mapHelper->renderHtmlContainer($map)!!}
		{!!$mapHelper->renderJavascripts($map)!!}
	@endif

@stop

@section('content-bottom')

	<p>
		{!! $translations['description'] or $location->description !!}
	</p>

@stop