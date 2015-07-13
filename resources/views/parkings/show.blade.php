@extends('halflayout')

@section('sidebar-left')

	<h2>Ads here</h2>
	<hr/>

@stop

@section('content-left')

	<table>
		<tr>
			<td width="85%"><h1>{{ $parking->parking_name }}</h1></td>
		</tr>
	</table>
	<h5>{{ $parking->address }}</h5>

	<?php 
		$btn_caption = NULL;
		/*if (!empty($parking->price) and $pcur['CURRENCY_ORDER'] == 'L') 
			$btn_caption = $pcur['CURRENCY'].(string)$parking->price;
		elseif (!empty($parking->price))
			$btn_caption = (string)$parking->price.' '.$pcur['CURRENCY'];*/
	?>

	@if ($btn_caption)
		<a href="{{ action('ParkingsController@book', [$parking->parking_id]) }}" class="btn btn-primary">{{ $btn_caption }} {{Lang::get('site.search_results_book_btn')}}</a>
	@endif

	<h4>{!! Lang::get('site.park_reserve_notes') !!}</h4>

	<p>
		{!! $translations['reserve_notes'] or $parking->reserve_notes !!}
	</p>

	<h4>{{ Lang::get('site.park_description') }}</h4>
	<p>
		{!! $translations['description'] or $parking->description !!}
	</p>

	<h4>{{ Lang::get('site.park_find_it') }}</h4>
	<p>
		{!! $translations['find_it'] or $parking->find_it !!}
	</p>

	<p>
		@foreach ($url as $value)
			<img src='https://www.parkinglegend.com/{{ $value }}' />
		@endforeach
	</p>

@stop

@section('content-right')

	
	{!!$mapHelper->renderHtmlContainer($map)!!}
	{!!$mapHelper->renderJavascripts($map)!!}

@stop