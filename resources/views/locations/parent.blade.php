@extends('layout57')

@section('title')
    {!! $translations['location_page_name'] or $location->location_page_name !!}
@stop

@section('sidebar-left')

	<h2>Ads here</h2>
	<hr/>

@stop

@section('content-left')

	<table>
		<tr>
			<td width="85%"><h1>{!! $translations['location_page_name'] or $location->location_page_name !!}</h1></td>
		</tr>
	</table>

	<div class="well well-yellow">
		<legend>
			<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
          	<span class="glyphicon-class">{{Lang::get('site.search_heading')}}</span>
		</legend>
		<!--{!! Form::open(['url' => '/results', 'id' => 'search']) !!}-->
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

	<?php $i=1; ?>
	<table class="table table-hover">
		<tr>
			@foreach ($child_locations as $child_location)
				@if($child_location->slug)
					<td><a href="{{URL::to('/')}}/{{App::getLocale()}}/{{ $child_location->parent_slug }}/{{ $child_location->slug }}">{{ $child_location->name }}</a></td>
					@if (($i%2)==0)
						</tr><tr>
					@endif
					<?php $i++; ?>
				@endif
			@endforeach
		</tr>
	</table>

@stop