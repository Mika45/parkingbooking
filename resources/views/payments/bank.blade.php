@extends('fulllayout')

@section('content')

	<form action='https://paycenter.piraeusbank.gr/redirection/pay.aspx' method='post' name='frm' target="pay">
		<input name="AcquirerId" type="hidden" value="{{$config['ONLINE_ACQUIRER_ID']}}" /> 
		<input name="MerchantId" type="hidden" value="{{$config['ONLINE_MERCHANT_ID']}}" /> 
		<input name="PosId" type="hidden" value="{{$config['ONLINE_POS_ID']}}" /> 
		<input name="User" type="hidden" value="{{$config['ONLINE_USERNAME']}}" /> 
		<input name="LanguageCode" type="hidden" value="el-GR" /> 
		<input name="MerchantReference" type="hidden" value="{{$booking_ref}}" /> 
		<input name="ParamBackLink" type="hidden" value="p1=v1&p2=v2" /> 
	</form>

	<iframe name="pay" src="" width="800" height="455"></iframe>

	<script language="JavaScript">
		document.frm.submit();
	</script>
@stop