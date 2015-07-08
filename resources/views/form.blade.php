<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title>
   Laravel
  </title>
 </head>
 <body>
  	{{ Form::open(array('url' => 'foo/bar')) }}
    
    {!! Form::label('name', 'Name:') !!}
	{{ Form::close() }}
 </body>
</html>