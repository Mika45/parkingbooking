@extends('booklayout')

@section('sidebar-left')
<h1>&nbsp;</h1>
	<div class="panel panel-info">
	  <div class="panel-heading">
	    <h3 class="panel-title">{{ Lang::get('site.book_sum_heading') }}</h3>
	  </div>
	  <div class="panel-body">
	  	<p><b>{{$parking->parking_name}}</b></p>
	  	<p>
	  	{{ Lang::get('site.dropoff') }}
	    <br/>
	    <b>{{Session::get('checkin')}}</b>
	    </p>
	    <p>
	    {{ Lang::get('site.pickup') }}
	    <br/>
	    <b>{{Session::get('checkout')}}</b>
		</p>
	  </div>
	</div>

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

@stop

@section('content')

	<h1>{{ Lang::get('site.book_form_heading') }}</h1>
	<p>

		<div class="well bs-component">
			<br/>
			
			{!! Form::open(['action' => 'ParkingsController@payment', 'class' => 'form-horizontal', 'id' => 'payment']) !!}
			<fieldset>

			@if (count($errors) > 0)
				<div class="alert alert-danger">
					{{ Lang::get('validation.errors_heading') }}<br><br>
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<?php $i = 0; ?>
			@foreach ($fields as $field)
				<?php $v_field = 'items['.$field->field_name.']'; ?>
				@if ($field->type === 'text')
				    
				    <div class="form-group">
				    	<label for="{{$field->field_name}}" class="col-lg-4 control-label">{{ $translations[$field->field_name] or $field->label }}</label>
				    	<div class="col-lg-8">
				    		
				    		<?php 
				    			if (array_key_exists($field->field_name, $translations)){
				    				$placeholder = $translations[$field->field_name];
				    			} else {
				    				$placeholder = $field->label;
				    			}
				    		?>
				    		@if(Auth::check())
				    			{!! Form::text($v_field, null, ['class' => 'form-control', 'placeholder' => $placeholder]) !!}
				    		@else
				    			{!! Form::text($v_field, null, ['class' => 'form-control', 'placeholder' => $placeholder]) !!}
				    		@endif
				    	</div>
				    </div>
				@elseif ($field->type === 'select')
					<div class="form-group">
						
						<?php 
							if ($field->field_name == 'country'){
								$selectArray = $countries;
							}
							elseif (!empty($title_attributes) and $field->field_name == 'title'){
								$selectArray = json_decode($title_attributes, true);
							}
							elseif (!empty($title_attributes) and $field->field_name == 'passengers'){
								$selectArray = json_decode($passengers_attributes, true);
							}
							else {
								$selectArray = json_decode($field->attributes, true);
							}
						?>
						<label for="{{$field->field_name}}" class="col-lg-4 control-label">{{ $translations[$field->field_name] or $field->label }}</label>

						<div class="col-lg-8">
					    	@if ($field->field_name == 'country')
						    	<select class="form-control selectpicker" id="items[{{$field->field_name}}]" name="items[{{$field->field_name}}]" data-showIcon="true" data-width="100%" data-size="10">
						    		<option value="" selected required>{{ Lang::get('site.book_form_country_list') }}</option>
						    	@foreach ($selectArray as $key => $value)
						    		<option data-icon="flag-icon flag-icon-{{$value['flag']}}" value="{{$value['country_id']}}">&nbsp;{{$value['locale']}} {{$value['code']}}</option>
						    	@endforeach
						    	</select>
						    @else
						    	{!! Form::select($field->field_name, $selectArray, 'default', ['class' => 'form-control'] ) !!}
						    @endif
					    </div>
				    </div>
				@else
				    Else case comes here
				@endif
				<?php $i++; /*$v_field = 'items['.$i.']';*/ ?>
			@endforeach

			<div class="form-group">
				<div class="col-lg-4">
				</div>
				<div class="col-lg-8">
			        {!! Form::checkbox('newsletter', 1, 1, ['class' => 'field', 'id' => 'terms']) !!}&nbsp;&nbsp;{!! Lang::get('site.reg_newsletter') !!}
			    </div>
		    </div>

			<div class="form-group">
				<div class="col-lg-4">
				</div>
				<div class="col-lg-8">
			        {!! Form::checkbox('items[terms]', 1, 0, ['class' => 'field', 'id' => 'terms']) !!}&nbsp;&nbsp;{!! Lang::get('site.common_accept_terms') !!}
			    </div>
		    </div>

			<div class="form-group">
				<div class="col-lg-8 col-lg-offset-4">
					{{-- {!! Form::submit(Lang::get('site.book_form_btn'), ['class' => 'btn btn-primary form-control']) !!} --}}
				</div>
			</div>

			</fieldset>
		{{-- {!! Form::close() !!} --}}
	</div>

	</p>

@stop

@section('sidebar-right')
<h1>&nbsp;</h1>
	<div class="panel panel-info">
	  <div class="panel-heading">
	    <h3 class="panel-title">{{ Lang::get('site.pay_sum_heading') }}</h3>
	  </div>
	  <div class="panel-body">
	  	{!! Form::radio('sex', 'male', true) !!}
	  	{!! Form::label('penyakit-0', Lang::get('site.pay_sum_opt_1')) !!}
	  	<br/>
	  	<input type="radio" name="foo" value="N" disabled>
	  	{!! Form::label('penyakit-0', Lang::get('site.pay_sum_opt_2')) !!}
	  	<p><small>{{Lang::get('site.pay_sum_opt_note')}}</small></p>
	  	<br/>
	  	{!! Form::submit(Lang::get('site.book_form_btn'), ['class' => 'btn btn-primary form-control']) !!}
	  	{!! Form::close() !!}
	  </div>
	  {{-- <div class="panel-footer"><strong>{{ Lang::get('site.book_sum_total') }} {{Session::get('selectedParking')['price']}}</strong></div> --}}
	  @if ( Session::get('currency')[$parking->parking_id]['currency_order'] == 'L' )
	  	<div id="currencyOrder" style="display: none;">Left</div>
	  	<div class="panel-footer">
	  		<strong>
	  			<table id="priceBreakdown" width="100%">
	  				<tr>
	  					<td>{{ Lang::get('site.book_sum_carpark') }}:</td> 
	  					<td align="right"><span id="currency">{{Session::get('currency')[$parking->parking_id]['currency']}}</span> <span id="parkingPrice">{{Session::get('selectedParking')['price']}}</span></td>
	  				</tr>
	  			</table>
	  		</strong>
	  	</div>
	  @else
	  	<div id="currencyOrder" style="display: none;">Right</div>
	  	<div class="panel-footer">
	  		<strong>
	  			{{-- {{ Lang::get('site.book_sum_total') }} {{Session::get('selectedParking')['price']}} {{Session::get('currency')[$parking->parking_id]['currency']}} --}}
	  			<table id="priceBreakdown" width="100%">
	  				<tr>
	  					<td>{{ Lang::get('site.book_sum_carpark') }}:</td> 
	  					<td align="right"><span id="parkingPrice">{{Session::get('selectedParking')['price']}}</span> <span id="currency">{{Session::get('currency')[$parking->parking_id]['currency']}}</span></td>
	  				</tr>
	  			</table>
	  		</strong>
	  	</div>
	  @endif

	</div>

	<script>

		$(document).ready(function(){

			$('[data-toggle="tooltip"]').tooltip();

			$('#prod_checks input:checkbox').change(function() {
				
				var productsPrice = 0;
				var totalPrice = 0;
				var productIds = [];

				$("#prod_checks input:checkbox").each(function() {
					if($(this).is(':checked')) {
						productIds.push($(this).val());
						productsPrice += parseFloat($(this).data('price'));
					}
				});

				// show total selected
				if(productsPrice === 0){
					$('#breakdown1').remove();
					$('#breakdown2').remove();
					totalPrice = parseFloat($("#parkingPrice").text());
				}else{
					totalPrice = productsPrice + parseFloat($("#parkingPrice").text());
					$('#breakdown1').remove();
					$('#breakdown2').remove();
					
					var cur = $("#currency").text();
					if($("#currencyOrder").text() == 'Right'){
						$('#priceBreakdown tr:last').after("<tr id='breakdown1'><td>{{ Lang::get('site.book_sum_products') }}:</td><td align='right'>" + productsPrice + ' ' + cur
															+ "</td></tr><tr id='breakdown2'><td>{{ Lang::get('site.book_sum_total') }}:</td><td align='right'><span id='total'>" + totalPrice + ' ' + cur + "</span></td></tr>");
					}else{
						$('#priceBreakdown tr:last').after("<tr id='breakdown1'><td>{{ Lang::get('site.book_sum_products') }}:</td><td align='right'>" + cur + ' ' + productsPrice 
															+ "</td></tr><tr id='breakdown2'><td>{{ Lang::get('site.book_sum_total') }}:</td><td align='right'><span id='total'>" + cur + ' ' + totalPrice + "</span></td></tr>");
					}
				}

				$.get('getRequest', { totalPrice:totalPrice, productsPrice:productsPrice, productIDs:productIds }, function(data){
					console.log(data);
				});
			});

			/*$('#getRequest').click(function(){

				var total = $('#total').val();
				
				$.get('getRequest', { totalPrice:total }, function(data){
					console.log(data);
				});
			});*/

		});

	</script>

@stop