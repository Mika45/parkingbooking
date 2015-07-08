<div class="form-group">

	<!-- {!! Form::text('location', Input::old('location'), ['class' => 'form-control']) !!} -->
	{!! Form::label('location', Lang::get('site.location')) !!}
	{!! Form::select('location', $locationsList, null, ['id' => 'location_list', 'class' => 'form-control']) !!}
	<br/><br/>
	
	{!! Form::label('checkin', Lang::get('site.dropoff')) !!}
	<div class='input-group date' id='datetimepicker1'>
		{!! Form::text('checkin', null, ['class' => 'form-control']) !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
	</div>
	<br/>
	{!! Form::label('checkout', Lang::get('site.pickup')) !!}
	<div class='input-group date' id='datetimepicker2'>
		{!! Form::text('checkout', null, ['class' => 'form-control']) !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
	</div>
	

</div>

<div class="form-group">
	{!! Form::submit(Lang::get('site.search'), ['class' => 'btn btn-info form-control']) !!}
</div>

@if ($errors->any())
	<ul class="alert alert-danger">
		@foreach ($errors->all() as $error)
			{{ $error }}<br/>
		@endforeach
	</ul>
@endif

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
	        format: 'DD/MM/YYYY H:mm',
    		extraFormats: [ 'YYYY-MM-DD H:mm' ],
			sideBySide: true,
    		stepping: 10,
    		minDate: moment(),
    		maxDate: moment().add(1, 'years').calendar()
    		//locale: moment.local('el')
	    });
        $('#datetimepicker2').datetimepicker({
	        //format: 'YYYY-MM-DD H:mm',
	        format: 'DD/MM/YYYY H:mm',
    		extraFormats: [ 'YYYY-MM-DD H:mm' ],
			sideBySide: true,
    		stepping: 10,
    		minDate: moment(),
    		maxDate: moment().add(1, 'years').calendar()
	    });
	    $("#datetimepicker1").on("dp.change", function (e) {
			$('#datetimepicker2').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker2").on("dp.change", function (e) {
            $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
        });
		
		
    });
</script>