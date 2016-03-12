@extends('layout')

@section('content')

	<h1>{{Lang::get('site.pay_success_head')}}</h1>
	<p>
		<iframe src="https://paycenter.piraeusbank.gr/redirection/pay.aspx" width="800" height="455"></iframe>
	</p>
@stop