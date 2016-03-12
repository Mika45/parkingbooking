@extends('layout')

@section('content')

	<h1>{{Lang::get('site.pay_success_head')}}</h1>
	<p>
		{!! Lang::get('site.pay_success_body') !!}
	</p>


	<form action='https://paycenter.piraeusbank.gr/redirection/pay.aspx' method='post' name='frm' target="pay">
		<input name="AcquirerId" type="hidden" value="14" /> 
		<input name="MerchantId" type="hidden" value="2133613386" /> 
		<input name="PosId" type="hidden" value="2139909353" /> 
		<input name="User" type="hidden" value="KA009598" /> 
		<input name="LanguageCode" type="hidden" value="el-GR" /> 
		<input name="MerchantReference" type="hidden" value="PL1506" /> 
		<input name="ParamBackLink" type="hidden" value="p1=v1&p2=v2" /> 

	</form>

	<iframe name="pay" src="" width="800" height="455"></iframe>

	<script language="JavaScript">
		document.frm.submit();
	</script>
@stop