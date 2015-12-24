@extends('halflayout')

@section('sidebar-left')

	<h2>Ads here</h2>
	<hr/>

@stop

@section('content-left')

	<table>
		<tr>
			<td width="85%"><h1>{!! $translations['parking_name'] or $parking->parking_name !!}</h1></td>
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

@stop

@section('content-right')
	
	{!!$mapHelper->renderHtmlContainer($map)!!}
	{!!$mapHelper->renderJavascripts($map)!!}

	@if(!is_null($url))
		<h5><b>{{ Lang::get('site.park_gallery') }}</b></h5>
		<p>
			<?php $i=1; ?>
			<div class="gallery">
				@foreach ($url as $value)
					{{-- <img src='https://www.parkinglegend.com/img/parkings/{{$parking->parking_id}}/thumb/{{ $value }}' /> --}}
					<a class="test-popup-link{{$i}}" href="#">
						<img src='{{url()}}/img/parkings/{{$parking->parking_id}}/thumb/{{ $value }}' />
					</a>

					<script>
						$('.test-popup-link{{$i}}').magnificPopup({ 
							items: {
						      src: '{{url()}}/img/parkings/{{$parking->parking_id}}/{{ $value }}'
						    },
						  	type: 'image',
							gallery: {
							  enabled: true, // set to true to enable gallery
							  preload: [0,2], // read about this option in next Lazy-loading section
							  navigateByImgClick: true,
							  arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>', // markup of an arrow button
							  tPrev: 'Previous (Left arrow key)', // title for left button
							  tNext: 'Next (Right arrow key)', // title for right button
							  tCounter: '<span class="mfp-counter">%curr% of %total%</span>' // markup of counter
							}
						});
					</script>
					<?php $i++; ?>
				@endforeach
			</div>
		</p>
	@endif

@stop