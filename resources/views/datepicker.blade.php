<html>

	<head>
		<title>Test the datepicker</title>

		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		{!! HTML::script('js/moment.js') !!}

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>-->
		{!! HTML::script('js/bootstrap.js') !!}

		{!! HTML::script('js/bootstrap-datetimepicker.js') !!}

		{!! HTML::style('css/bootstrap-datetimepicker.css') !!}

	</head>

	<body>
		
		<div class="container">
		    <div class="row">
		        <div class='col-sm-6'>
		            <div class="form-group">
		                <div class='input-group date' id='datetimepicker1'>
		                    <input type='text' class="form-control" />
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
		            </div>
		        </div>
		        <script type="text/javascript">
		            $(function () {
		                $('#datetimepicker1').datetimepicker();
		            });
		        </script>
		    </div>
		</div>

	</body>

</html>