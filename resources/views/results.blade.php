@extends('halflayout')

@section('content-left')

	<h1>{{Lang::get('site.search_results_heading')}}</h1>

	<h5>
		{!!$location[0]->name!!}, 
		{{ Lang::get('site.search_results_from') }} <b>{{ $checkin }}</b>
		{{ Lang::get('site.search_results_to') }} <b>{{ $checkout }}</b>
	</h5>

	@if ($count>0)
		<h4>{{$count}} {{Lang::choice('site.search_results_count', $count)}}</h4>
	@else
		<h4>{{Lang::choice('site.search_results_count', $count)}}</h4>
	@endif
	
	
	@if ($count>0)
		<table class="table table-hover">
		  	@foreach ($data as $parking)
				<tr>
					<td><img class="media-object" src="/img/default-p.png" alt="..."></td>
					<td>
						<a href="{{ action('ParkingsController@show', [$parking->parking_id]) }}"><b>{{ $parking->parking_name }}</b></a>
						{{-- <b>{{ $parking->parking_name }}</b> --}}
						<?php //echo '<a href="#" onclick="showBox('.Session::get('JSinstances')[$parking->parking_id].');"><b>'.$parking->parking_name.'</b></a>'; ?>
						<br>
						{{ $parking->address }}
						<br>
						<?php //echo '<a href="#" onclick="showBox('.Session::get('JSinstances')[$parking->parking_id].');">'.Lang::get('site.search_results_find_on_map').'</a>'; ?>
						
						@foreach ($parking->tags as $key => $tag)
							<img src='/img/icons/{{ $key }}' title='{{ $tag }}' />
						@endforeach
					</td>
					<td>
						<?php 
							if ($parking->currency_order == 'L') 
								$btn_caption = $parking->currency.(string)$parking->price;
							else
								$btn_caption = (string)$parking->price.' '.$parking->currency;
						?>


						@if ( $parking->available == 'Y' and $parking->late_booking == 'N' )
							<a href="{{ action('ParkingsController@book', [$parking->parking_id]) }}" class="btn btn-primary btn-block">{{ $btn_caption }} {{Lang::get('site.search_results_book_btn')}}</a>
						@else
							<a href="{{ action('ParkingsController@book', [$parking->parking_id]) }}" class="btn btn-primary btn-block disabled">{{Lang::get('site.common_na')}}</a>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
	@endif

@stop


@section('content-right')

	@if ($count>0)

		{!!$mapHelper->renderHtmlContainer($map)!!}
		{!!$mapHelper->renderJavascripts($map)!!}
		
	@endif


	<?php
		echo "<script>";
		//echo "var mapDiv = document.getElementById('map-canvas');";
		foreach (Session::get('JSinstances') as $insta){
			echo "google.maps.event.addDomListener(".$insta.", 'click', showBox);";
		}
		echo "</script>";
	?>
	<script>
		//var mapDiv = document.getElementById('map-canvas');
		//google.maps.event.addDomListener({{Session::get('JSinstance')}}, 'click', showBox);
		function showBox(in_marker) {
		  //window.alert('DIV clicked');
		  google.maps.event.trigger(in_marker, 'click');
		  //map.setCenter(0,0);
		}
	</script>


@stop