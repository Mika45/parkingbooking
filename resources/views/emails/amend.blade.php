<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>ParkingLegend.com</title>
	<style>
	  body { font-family: DejaVu Sans, sans-serif; }
	</style>
	</head>
	<body>
		@foreach ($booking as $bk)
			<h1>ParkingLegend.com</h1>
			<h3>{{Lang::get('emails.booking_conf_thanks')}} {{$bk->firstname}}! {{Lang::get('emails.booking_amend_message')}}</h3>

		
			<p>{{Lang::get('emails.common_ref')}}: {{$bk->booking_ref}}</p>
			<p>{{$bk->checkin}} - {{$bk->checkout}}</p>
			<p>{{Lang::get('emails.common_reg')}}: {{$bk->car_reg}}</p>
			<p>{{Lang::get('emails.common_name')}}: {{$bk->firstname}} {{$bk->lastname}}</p>
		@endforeach

	</body>

</html>