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
	  	<div class="panel-footer"><strong>{{ Lang::get('site.book_sum_total') }} {{Session::get('currency')[$parking->parking_id]['currency']}}{{Session::get('selectedParking')['price']}}</strong></div>
	  @else
	  	<div class="panel-footer"><strong>{{ Lang::get('site.book_sum_total') }} {{Session::get('selectedParking')['price']}} {{Session::get('currency')[$parking->parking_id]['currency']}}</strong></div>
	  @endif
	</div>
@stop

<script>
	$('select').selectpicker();
</script>