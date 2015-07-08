<html>
	<head>
		<link href="{{ asset('public/css/bootstrap.css') }}" rel="stylesheet" type="text/css" >

		<title>Search box test</title>
	</head>

<body>

	<h1>Search Parkings</h1>

	{!! Form::open() !!}

		<div class="form-group">
			{!! Form::label('name', 'Name:') !!}
			{!! Form::text('name', null, ['class' => 'form-control']) !!}
		</div>


	{!! Form::close() !!}

</body>
</html>