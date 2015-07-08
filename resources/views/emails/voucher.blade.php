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
		<h3>{{Lang::get('emails.voucher_heading')}}</h3>
		<p>{{Lang::get('emails.voucher_intro')}}</p>
		@foreach ($booking as $bk)
			<p>{{Lang::get('emails.common_ref')}}: <strong>{{$bk->booking_ref}}</strong></p>
			<p>{{$bk->checkin}} - {{$bk->checkout}}</p>
			<p>{{Lang::get('emails.common_park')}}: {{$bk->parking_name}}, {{$bk->address}}</p>
			<p>{{Lang::get('emails.common_name')}}: {{$bk->firstname}} {{$bk->lastname}}</p>
			<p>{{Lang::get('emails.common_reg')}}: {{$bk->car_reg}}</p>
			
			<h4>{{Lang::get('emails.voucher_notes')}}</h4>
			<p>{!!$bk->reserve_notes!!}</p>

			{{-- <h4>{{Lang::get('emails.voucher_desc')}}</h4>
			<p>{!!$bk->description!!}</p> --}}

			<h4>{{Lang::get('emails.voucher_find')}}</h4>
			<p>{!!$bk->find_it!!}</p>
		@endforeach

	</body>

</html>