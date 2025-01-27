@extends('layout')

@section('sidebar')
	<h1>&nbsp;</h1>
	<div class="panel panel-info">
	  <div class="panel-heading">
	    <h3 class="panel-title">{{Lang::get('site.book_sum_heading')}}</h3>
	  </div>
	  <div class="panel-body">
	  	<p><b>{{ $summary['parking_name'] }}</b></p>
	  	<p>
	  	{{ Lang::get('site.dropoff') }}
	    <br/>
	    <b>{{ $summary['checkin'] }}</b>
	    </p>
	    <p>
	    {{ Lang::get('site.pickup') }}
	    <br/>
	    <b>{{ $summary['checkout'] }}</b>
		</p>
	  </div>
	  <div class="panel-footer">
		  <strong>
			  <table width="100%">
				  <tr>
					  <td>{{ Lang::get('site.book_sum_total') }}:</td>
					  @if ( Session::get('currency')[$booking->parking_id]['currency_order'] == 'L' )
					      <td align="right"><span id="currency">{{Session::get('currency')[$booking->parking_id]['currency']}}</span> <span id="parkingPrice">{{ $booking->price }}</span></td>
					  @else
						  <td align="right"><span id="parkingPrice">{{ $booking->price }}</span> <span id="currency">{{Session::get('currency')[$booking->parking_id]['currency']}}</span></td>
					  @endif
				  </tr>
			  </table>
		  </strong>
	  </div>
	</div>

	{{--
	@if (count($products) > 0)

		<div class="panel panel-info">
			<div class="panel-heading">
		    	<h3 class="panel-title">{{ Lang::get('site.book_products_heading') }}</h3>
		  	</div>
		  	<div class="panel-body">

		  		<div class="checkbox" id="prod_checks">
		  		@foreach ($products as $product)
		        	<label>
		            	<input type="checkbox" id="product_option{{ $product->product_id }}" data-price="{{ $product->price }}" name="product_option{{ $product->product_id }}" value="{{ $product->product_id }}">
		            	 	{{ $p_trans[$product->product_id]['name'] or $product->name }} @if($product->description)
		            	 	 <span class="label label-primary" data-toggle="tooltip" data-placement="bottom" title="{{ $p_trans[$product->product_id]['description'] or $product->description }}">?</span> @endif
		          	</label>
		          	<br/>
			  	@endforeach
			  	</div>

		  	</div>
		</div>

	@endif
	--}}

@stop

@section('content')

	<h1>{{ Lang::get('site.checkout_heading') }}</h1>

	<div class="well">
		<img src="/img/bank/Visa.jpg" />&nbsp;&nbsp;
		<img src="/img/bank/Mastercard.jpg" />&nbsp;&nbsp;
		<img src="/img/bank/Maestro.jpg" />&nbsp;&nbsp;
		<img src="/img/bank/vbv.jpg" />&nbsp;&nbsp;
		<img src="/img/bank/sc_62x34.gif" />&nbsp;&nbsp;
	</div>

	<form action='https://paycenter.piraeusbank.gr/redirection/pay.aspx' method='post' name='frm' target="pay">
		<input name="AcquirerId" type="hidden" value="{{$config['ONLINE_ACQUIRER_ID']}}" />
		<input name="MerchantId" type="hidden" value="{{$config['ONLINE_MERCHANT_ID']}}" />
		<input name="PosId" type="hidden" value="{{$config['ONLINE_POS_ID']}}" />
		<input name="User" type="hidden" value="{{$config['ONLINE_USERNAME']}}" />
		<input name="LanguageCode" type="hidden" value="{{$iframe_lang}}" />
		<input name="MerchantReference" type="hidden" value="{{$booking_ref}}" />
	</form>

	<iframe name="pay" src="" width="800" height="455" frameBorder="0"></iframe>

	<script language="JavaScript">
		document.frm.submit();
	</script>
@stop
