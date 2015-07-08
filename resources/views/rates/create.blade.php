@extends('booklayout')

@section('content')

<h1>Add new Rates</h1>

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

	{!! Form::open(['action' => 'RatesController@store', 'class' => 'form-horizontal', 'id' => 'ratestore']) !!}
		@include('forms.rates')
	{!! Form::close() !!}
</div>
@stop
