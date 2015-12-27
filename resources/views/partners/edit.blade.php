@extends('fulllayout')

@section('content')

<h1>Edit Affiliate</h1>

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

	{!! Form::model($affiliate, ['method' => 'PATCH', 'action' => ['PartnersController@update', $affiliate->affiliate_id], 'id' => 'affiliate']) !!}
		@include('forms.affiliate')
	{!! Form::close() !!}
</div>
@stop