<fieldset>
	<div class="form-group">

		<?php
			if (isset($defaultLocation))
				$default = $defaultLocation;
			else
				$default = 18; // Athens airport
		?>

		<div class="col-lg-12">
			{!! Form::label('location', Lang::get('site.location')) !!}
			{!! Form::select('location', $locationsList, $default, ['id' => 'location_list', 'class' => 'form-control']) !!}
		</div>

	</div>
	
	<div class="form-group">
		
		<div class="col-lg-6">
			{!! Form::label('checkindate', Lang::get('site.dropoff_date')) !!}
			<div class='input-group date' id='datetimepicker1'>
				{!! Form::text('checkindate', null, ['class' => 'form-control']) !!}
		        <span class="input-group-addon">
		            <span class="glyphicon glyphicon-calendar"></span>
		        </span>
			</div>
		</div>

		<div class="col-lg-6">
			{!! Form::label('checkintime', Lang::get('site.dropoff_time')) !!}
			<div class='input-group date' id='datetimepicker2'>
				{!! Form::text('checkintime', null, ['class' => 'form-control']) !!}
		        <span class="input-group-addon">
		            <span class="glyphicon glyphicon-time"></span>
		        </span>
			</div>
		</div>

	</div>
	
	<div class="form-group">
		
		<div class="col-lg-6">
			{!! Form::label('checkoutdate', Lang::get('site.pickup_date')) !!}
			<div class='input-group date' id='datetimepicker3'>
				{!! Form::text('checkoutdate', null, ['class' => 'form-control']) !!}
		        <span class="input-group-addon">
		            <span class="glyphicon glyphicon-calendar"></span>
		        </span>
			</div>
		</div>

		<div class="col-lg-6">
			{!! Form::label('checkouttime', Lang::get('site.pickup_time')) !!}
			<div class='input-group date' id='datetimepicker4'>
				{!! Form::text('checkouttime', null, ['class' => 'form-control']) !!}
		        <span class="input-group-addon">
		            <span class="glyphicon glyphicon-time"></span>
		        </span>
			</div>
		</div>
		

	</div>
	
	<div class="form-group">
		<div class="col-lg-6">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
	        <span class="glyphicon-class">{{Lang::get('content.home_slogan_1')}}</span>
	    </div>
	    <div class="col-lg-6">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
	        <span class="glyphicon-class">{{Lang::get('content.home_slogan_2')}}</span>
	    </div>
	</div>
	<div class="form-group">
	    <div class="col-lg-6">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
	        <span class="glyphicon-class">{{Lang::get('content.home_slogan_3')}}</span>
	    </div>
	    <div class="col-lg-6">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
	        <span class="glyphicon-class">{{Lang::get('content.home_slogan_4')}}</span>
	    </div>
    </div>
	
	<div class="form-group">
		<div class="col-lg-12">
			{!! Form::submit(Lang::get('site.search'), ['class' => 'btn btn-info form-control']) !!}
		</div>
	</div>

	@if ($errors->any())
		<div class="form-group">
			<div class="col-lg-12">
				<ul class="alert alert-danger">
					@foreach ($errors->all() as $error)
						{{ $error }}<br/>
					@endforeach
				</ul>
			</div>
		</div>	
	@endif

</fieldset>

<script>
	$('#location_list').select2({
		//placeholder: "Choose a Location",
	});
	/*$(document).ready(function() {
  		$(".js-example-basic-single").select2();
	});*/
</script>

<script>
    $(function () {
        $('#datetimepicker1').datetimepicker({
	        //format: 'YYYY-MM-DD H:mm',
	        useCurrent: false,
	        format: 'DD/MM/YYYY',
    		minDate: moment(),
    		maxDate: moment().add(0.5, 'years').calendar()
    		//locale: moment.local('el')
	    });
        $('#datetimepicker2').datetimepicker({
	        //format: 'YYYY-MM-DD H:mm',
	        useCurrent: false,
	        format: 'H:mm',
    		stepping: 10
	    });
	    $('#datetimepicker3').datetimepicker({
	        //format: 'YYYY-MM-DD H:mm',
	        useCurrent: false,
	        format: 'DD/MM/YYYY',
    		minDate: moment(),
    		maxDate: moment().add(0.5, 'years').calendar()
    		//locale: moment.local('el')
	    });
        $('#datetimepicker4').datetimepicker({
	        //format: 'YYYY-MM-DD H:mm',
	        useCurrent: false,
	        format: 'H:mm',
    		stepping: 10
	    });
	    /*$("#datetimepicker1").on("dp.change", function (e) {
			$('#datetimepicker3').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker3").on("dp.change", function (e) {
            $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
        });*/
		
		
    });
</script>