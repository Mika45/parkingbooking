<?php 
	if (!array_key_exists('CANCEL_THRESHOLD', $configArray))
		$configArray['CANCEL_THRESHOLD'] = null;

	if (!array_key_exists('CURRENCY', $configArray))
		$configArray['CURRENCY'] = null;

	if (!array_key_exists('CURRENCY_ORDER', $configArray))
		$configArray['CURRENCY_ORDER'] = null;
?>
<div class="form-group">
	<fieldset>
		<div class="form-group">
			<div class="col-lg-4">
				{!! Form::label('parking_name', 'Parking name:') !!}
				{!! Form::text('parking_name', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-2">
				{!! Form::label('cancel_threshold', 'Cancel before hours:') !!}
				{!! Form::text('cancel_threshold', $configArray['CANCEL_THRESHOLD'], ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-2">
				{!! Form::label('rate_type', 'Rate type:') !!}
				{!! Form::select('rate_type', [
				   'C' => 'Calendar Daily',
				   'D' => 'Daily',
				   'H' => 'Hourly'], null, ['class' => 'form-control']
				) !!}
    		</div>
    		<div class="col-lg-2">
				{!! Form::label('status', 'Status:') !!}
				{!! Form::select('status', ['A' => 'Active',
				   							'I' => 'Inactive'], null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-1">
				{!! Form::label('slots', 'Slots:') !!}
				{!! Form::text('slots', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-1">
				{!! Form::label('24hour', '24 Hour:') !!}
				{!! Form::select('24hour', ['N' => 'N',
				   							'Y' => 'Y'], null, ['class' => 'form-control']) !!}
    		</div>
    	</div>
    	<br/><br/><br/>
    	<div class="form-group">
			<div class="col-lg-4">
				{!! Form::label('address', 'Address:') !!}
				{!! Form::text('address', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-2">
    			{!! Form::label('early_booking', 'Booking deadline (h):') !!}
    			{!! Form::text('early_booking', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-2">
				{!! Form::label('min_duration', 'Min booking (hours):') !!}
				{!! Form::select('min_duration', [
				   '1' => '1', '2' => '2',
				   '3' => '3', '4' => '4',
				   '5' => '5', '6' => '6',
				   '7' => '7', '8' => '8',
				   '9' => '9', '10' => '10',
				   '11' => '11', '12' => '12',
				   '13' => '13', '14' => '14',
				   '15' => '15', '16' => '16',
				   '17' => '17', '18' => '18',
				   '19' => '19', '20' => '20',
				   '21' => '21', '22' => '22',
				   '23' => '23', '24' => '24'], null, ['class' => 'form-control']
				) !!}
    		</div>
    		<div class="col-lg-2">
				{!! Form::label('lat', 'Μap latitude:') !!}
				{!! Form::text('lat', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-2">
				{!! Form::label('lng', 'Μap longtitude:') !!}
				{!! Form::text('lng', null, ['class' => 'form-control']) !!}
    		</div>
    	</div>
    	<br/><br/><br/>
    	<div class="form-group">
    		<div class="col-lg-4">
    			{!! Form::label('email', 'E-mail:') !!}
				{!! Form::text('email', null, ['class' => 'form-control']) !!}
    		</div>
			<div class="col-lg-2">
				{!! Form::label('currency', 'Currency:') !!}
				{!! Form::text('currency', $configArray['CURRENCY'], ['class' => 'form-control']) !!}
    		</div>
    		
    		<div class="col-lg-2">
				{!! Form::label('currency_order', 'Currency order:') !!}
				{!! Form::select('currency_order', ['L' => 'Left',
				   									'R' => 'Right'], $configArray['CURRENCY_ORDER'], ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-4">
    			{!! Form::label('images', 'Images:') !!}
				{!! Form::file('images[]', array('multiple'=>true)) !!}
    		</div>
    	</div>
    	<br/><br/><br/>
    	<div class="form-group">
			<div class="col-lg-4">
				{!! Form::label('phone1', 'Phone 1:') !!}
				{!! Form::text('phone1', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-4">
				{!! Form::label('phone2', 'Phone 2:') !!}
				{!! Form::text('phone2', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-4">
				{!! Form::label('mobile', 'Mobile:') !!}
				{!! Form::text('mobile', null, ['class' => 'form-control']) !!}
    		</div>
    	</div>
    	<br/><br/><br/>
    	<div class="form-group">
			<div class="col-lg-4">
				{!! Form::label('description', 'Parking description:') !!}
				{!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-4">
				{!! Form::label('find_it', 'Directions:') !!}
				{!! Form::textarea('find_it', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-4">
				{!! Form::label('reserve_notes', 'Reserve notes:') !!}
				{!! Form::textarea('reserve_notes', null, ['class' => 'form-control']) !!}
    		</div>
    	</div>
    	
    	<div class="form-group">
			<div class="col-lg-3">
				<br/>
				{!! Form::label('locations', 'Associate locations:') !!}
				{!! Form::select('locations[]', $p_locations, $p_locations_selected, ['multiple', 'class' => 'form-control']) !!}
			</div>
			<div class="col-lg-3">
				<br/>
				{!! Form::label('fields', 'Associate fields:') !!}
				{!! Form::select('fields[]', $p_fields, $p_fields_selected, ['multiple', 'class' => 'form-control']) !!}
			</div>
			<div class="col-lg-3">
				<br/>
				{!! Form::label('tags', 'Associate tags:') !!}
				{!! Form::select('tags[]', $tags, $tags_selected, ['multiple', 'class' => 'form-control']) !!}
			</div>
			<div class="col-lg-3">
				<br/>
				{!! Form::label('products', 'Associate products:') !!}
				{!! Form::select('products[]', $products, $products_selected, ['multiple', 'class' => 'form-control']) !!}
			</div>
		</div>

		<br/><br/><br/>
		<div class="form-group">
			<div class="col-lg-4">
				
			</div>
			<div class="col-lg-4">
				
			</div>
			<div class="col-lg-2">
				
			</div>
			<div class="col-lg-2">
				<br/>
				{!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
			</div>
		</div>
    </fieldset>

</div>

<script>
	function valueChanged() {

	    if ($('#non-working-hours-1').is(':checked')) {
		    document.getElementById("from_time_bd").disabled = false;
		    document.getElementById("to_time_bd").disabled = false;
		} else {
		    document.getElementById("from_time_bd").disabled = true;
		    document.getElementById("to_time_bd").disabled = true;
		}

		if ($('#non-working-hours-2').is(':checked')) {
		    document.getElementById("from_time_sat").disabled = false;
		    document.getElementById("to_time_sat").disabled = false;
		} else {
		    document.getElementById("from_time_sat").disabled = true;
		    document.getElementById("to_time_sat").disabled = true;
		}

		if ($('#non-working-hours-3').is(':checked')) {
		    document.getElementById("from_time_sun").disabled = false;
		    document.getElementById("to_time_sun").disabled = false;
		} else {
		    document.getElementById("from_time_sun").disabled = true;
		    document.getElementById("to_time_sun").disabled = true;
		}

	}
</script>