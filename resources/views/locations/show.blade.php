@extends('halflayout')

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

	{{-- <h4>{{ Lang::get('site.park_description') }}</h4> --}}
	<p>
		{!! $translations['description'] or $location->description !!}
	</p>

	<p>
		
	</p>

@stop

@section('content-right')
	<h1>&nbsp;</h1>

	@if (isset($location->lat) && isset($location->lng))
		{!!$mapHelper->renderHtmlContainer($map)!!}
		{!!$mapHelper->renderJavascripts($map)!!}
	@endif

@stop