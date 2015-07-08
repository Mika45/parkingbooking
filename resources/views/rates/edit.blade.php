@extends('booklayout')

@section('content')

<h1>Edit rates for {{$parking->parking_name}}</h1>

<div class="well">

	@if (count($errors) > 0)
		<div class="alert alert-danger">
			There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	{!! Form::model($rate, ['method' => 'PATCH', 'action' => ['RatesController@update', $rate->rate_id], 'class' => 'form-horizontal', 'id' => 'rateupdate']) !!}
		@include('forms.rates')
	{!! Form::close() !!}
</div>
@stop