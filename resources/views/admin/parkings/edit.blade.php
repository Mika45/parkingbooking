@extends('templates.admin')

@section('content')

<div class="row">
   <!-- left column -->
   <div class="col-md-12">
     	<!-- general form elements -->
     	<div class="box box-primary">
       	@if (isset($box_title))
       	<div class="box-header with-border">
         	<h3 class="box-title">{{ $box_title or null }}</h3>
       	</div><!-- /.box-header -->
       	@endif

       	@if (count($errors) > 0)
			<div class="alert alert-danger">
				{{Lang::get('validation.errors_heading')}}<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif

			{!! Form::model($parking, ['method' => 'PATCH', 'action' => ['ParkingsController@update', $parking->parking_id], 'id' => 'search', 'files' => true]) !!}
				@include('admin.forms.parking')
			{!! Form::close() !!}
		</div>
	</div>
</div>

@stop