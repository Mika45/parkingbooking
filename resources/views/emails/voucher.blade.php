<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Booking Voucher</title>
	<style>
	  body { font-family: DejaVu Sans, sans-serif; }
	</style>
	</head>
	<body>

		{{-- <h1>ParkingLegend.com</h1> --}}
		<img src="http://www.parkinglegend.com/img/logo-blue.jpg" />
		
		@foreach ($booking as $bk)
			@if ($bk->status == 'A')
				<h3>{{Lang::get('emails.voucher_subject_amend')}}</h3>
			@else
				<h3>{{Lang::get('emails.voucher_heading')}}</h3>
			@endif
			<p>{{Lang::get('emails.voucher_intro')}}</p>

			<p>{{Lang::get('emails.common_ref')}}: <strong>{{$bk->booking_ref}}</strong></p>
			<p>{{Lang::get('emails.voucher_price')}}: 
				@if ($bk->currency_order == 'L') {{$bk->currency}} @endif {{$bk->price}} @if($bk->currency_order == 'R') {{$bk->currency}} @endif

				@if ($bk->status == 'A') 
					@if ($bk->price_diff < 0)
						({{$bk->price_old}} {{$bk->price_diff}})
					@else
						({{$bk->price_old}} + {{$bk->price_diff}})
					@endif
				@endif

				@if ($products)
					<br/>
					{{Lang::get('emails.voucher_services')}}: <br/>
					@foreach ($products as $prod)
						@if ($bk->currency_order == 'L')
							{{$prod->name}} ({{$bk->currency}}{{$prod->price}}) <br/>
						@else
							{{$prod->name}} ({{$prod->price}} {{$bk->currency}}) <br/>
						@endif
					@endforeach
				@endif
			</p>
			<p>{{$bk->checkin}} - {{$bk->checkout}}</p>
			<p>
				{{Lang::get('emails.common_park')}}: {{$bk->parking_name}}, {{$bk->address}}
				<br/>
				
				{{Lang::get('emails.common_phone')}}: {{$bk->phone1}} 
				@if($bk->phone2)
					, {{$bk->phone2}}
				@endif
				@if($bk->pmobile)
					, {{$bk->pmobile}}
				@endif
			</p>
			<p>{{Lang::get('emails.common_name')}}: {{$bk->title}} {{$bk->firstname}} {{$bk->lastname}}</p>
			<p>{{Lang::get('emails.common_mob')}}: @if($bk->phone_code) (+{{$bk->phone_code}}) @endif {{$bk->mobile}}</p>
			<p>{{Lang::get('emails.common_email')}}: {{$bk->email}}</p>
			<p>
				{{Lang::get('emails.common_reg')}}: {{$bk->car_reg}}<br/>
				@if($bk->car_make) {{Lang::get('emails.common_car_make')}}: {{$bk->car_make}} <br/> @endif
				@if($bk->car_model) {{Lang::get('emails.common_car_model')}}: {{$bk->car_model}} <br/> @endif
				@if($bk->car_colour) {{Lang::get('emails.common_car_colour')}}: {{$bk->car_colour}} <br/> @endif
				@if($bk->passengers) {{Lang::get('emails.common_passengers')}}: {{$bk->passengers}} @endif
			</p>
			
			<h4>{{Lang::get('emails.voucher_notes')}}</h4>
			{!! $translations['reserve_notes'] or $bk->reserve_notes !!}

			<h4>{{Lang::get('emails.voucher_find')}}</h4>
			{!! $translations['find_it'] or $bk->find_it !!}
		@endforeach

	</body>

</html>