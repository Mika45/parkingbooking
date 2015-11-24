<html>
	<head>
		 <meta charset="UTF-8"> 
		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 100;
				font-family: 'Arial';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 72px;
				margin-bottom: 40px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<img src="/img/logo-blue.jpg" />
				<div class="title">{!! Lang::get('error.403_title') !!}</div>
				<p>{!! Lang::get('error.403_msg', ['name' => url("/")]) !!}</p>
			</div>
		</div>
	</body>
</html>
