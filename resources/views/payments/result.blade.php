@extends('layout')

@section('content')

	@if ($name == 'success')

		<h1>{{Lang::get('site.pay_success_head')}}</h1>
		<p>
			{!! Lang::get('site.pay_success_body') !!}
		</p>

	@elseif ($name == 'failure')

		<h1>{{Lang::get('site.pay_failure_head')}}</h1>
		<p>
			{!! Lang::get('site.pay_failure_body') !!}
		</p>

	@elseif ($name == 'cancel')

		<h1>{{Lang::get('site.pay_cancel_head')}}</h1>
		<p>
			{!! Lang::get('site.pay_cancel_body') !!}
		</p>

	@endif

@stop