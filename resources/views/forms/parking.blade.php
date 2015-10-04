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
				{!! Form::select('24hour', ['Y' => 'Y',
				   							'N' => 'N'], null, ['class' => 'form-control']) !!}
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
			<div class="col-lg-4">
				<br/>
				{!! Form::label('locations', 'Associate locations:') !!}
				{!! Form::select('locations[]', $p_locations, $p_locations_selected, ['multiple', 'class' => 'form-control']) !!}
			</div>
			<div class="col-lg-4">
				<br/>
				{!! Form::label('fields', 'Associate fields:') !!}
				{!! Form::select('fields[]', $p_fields, $p_fields_selected, ['multiple', 'class' => 'form-control']) !!}
			</div>
			<div class="col-lg-4">
				<br/>
				{!! Form::label('tags', 'Associate tags:') !!}
				{!! Form::select('tags[]', $tags, $tags_selected, ['multiple', 'class' => 'form-control']) !!}
			</div>
		</div>

		{{--
		<div class="form-group">
			<div class="col-lg-4">
				<br/>
				<fieldset class="user-settings-question">
				    @if ($from_time_bd == 'na')
				    	{!! Form::checkbox('non-working-hours-1', 1, null, ['id' => 'non-working-hours-1', 'onChange' => 'valueChanged()']) !!}
				    @else
				    	{!! Form::checkbox('non-working-hours-1', 1, 1, ['id' => 'non-working-hours-1', 'onChange' => 'valueChanged()']) !!}
				    @endif
				    {!! Form::label('non-working-hours-1', 'NON working hours (business days)') !!}
				</fieldset>
			</div>
			<div class="col-lg-4">
				<br/>
				<fieldset class="user-settings-question">
					@if ($from_time_sat == 'na')
				    	{!! Form::checkbox('non-working-hours-2', 1, null, ['id' => 'non-working-hours-2', 'onChange' => 'valueChanged()']) !!}
				    @else
				    	{!! Form::checkbox('non-working-hours-2', 1, 1, ['id' => 'non-working-hours-2', 'onChange' => 'valueChanged()']) !!}
				    @endif
				    {!! Form::label('non-working-hours-2', 'NON working hours (Saturdays)') !!}
				</fieldset>
			</div>
			<div class="col-lg-4">
				<br/>
				<fieldset class="user-settings-question">
					@if ($from_time_sun == 'na')
				    	{!! Form::checkbox('non-working-hours-3', 1, null, ['id' => 'non-working-hours-3', 'onChange' => 'valueChanged()']) !!}
				    @else
				    	{!! Form::checkbox('non-working-hours-3', 1, 1, ['id' => 'non-working-hours-3', 'onChange' => 'valueChanged()']) !!}
				    @endif
				    {!! Form::label('non-working-hours-3', 'NON working hours (Sundays)') !!}
				</fieldset>
			</div>
		</div>

		<div class="form-group">
			<div class="col-lg-2">
				<br/>
				{!! Form::label('from_time_bd', 'From:') !!}
				@if ($from_time_bd == 'na')
					{!! Form::select('from_time_bd', $hours, null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
				@else
					{!! Form::select('from_time_bd', $hours, $from_time_bd, ['class' => 'form-control']) !!}
				@endif
			</div>
			<div class="col-lg-2">
				<br/>
				{!! Form::label('to_time_bd', 'To:') !!}
				@if ($to_time_bd == 'na')
					{!! Form::select('to_time_bd', $hours, null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
				@else
					{!! Form::select('to_time_bd', $hours, $to_time_bd, ['class' => 'form-control']) !!}
				@endif
			</div>
			<div class="col-lg-2">
				<br/>
				{!! Form::label('from_time_sat', 'From:') !!}
				@if ($from_time_sat == 'na')
					{!! Form::select('from_time_sat', $hours, null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
				@else
					{!! Form::select('from_time_sat', $hours, $from_time_sat, ['class' => 'form-control']) !!}
				@endif
			</div>
			<div class="col-lg-2">
				<br/>
				{!! Form::label('to_time_sat', 'To:') !!}
				@if ($to_time_sat == 'na')
					{!! Form::select('to_time_sat', $hours, null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
				@else
					{!! Form::select('to_time_sat', $hours, $to_time_sat, ['class' => 'form-control']) !!}
				@endif
			</div>

			<div class="col-lg-2">
				<br/>
				{!! Form::label('from_time_sun', 'From:') !!}
				@if ($from_time_sun == 'na')
					{!! Form::select('from_time_sun', $hours, null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
				@else
					{!! Form::select('from_time_sun', $hours, $from_time_sun, ['class' => 'form-control']) !!}
				@endif
			</div>
			<div class="col-lg-2">
				<br/>
				{!! Form::label('to_time_sun', 'To:') !!}
				@if ($to_time_sun == 'na')
					{!! Form::select('to_time_sun', $hours, null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
				@else
					{!! Form::select('to_time_sun', $hours, $to_time_sun, ['class' => 'form-control']) !!}
				@endif
			</div>
		</div>
		--}}
		
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