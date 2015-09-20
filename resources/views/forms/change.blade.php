<div class="form-group">

	<!-- {!! Form::text('location', Input::old('location'), ['class' => 'form-control']) !!} -->
	{!! Form::label('parking', Lang::get('site.amend_parking')) !!}
	{!! Form::text('parking', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
	<br/>
	
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
	<br/>
	{!! Form::label('price', Lang::get('site.back_book_price')) !!}
	{!! Form::text('price', null, ['class' => 'form-control', 'readonly']) !!}

	{!! Form::hidden('id', $booking->booking_id) !!}
	

</div>

@if (session()->has('msg'))
	<div class="alert alert-dismissible alert-danger">
	  <button type="button" class="close" data-dismiss="alert">×</button>
	  {!! session('msg') !!}
	</div>
@endif

<fieldset>
<div class="form-group">
	<div class="col-lg-6">
		{!! Form::submit(Lang::get('site.search'), ['class' => 'btn btn-info form-control', 'name' => 'search']) !!}
	</div>
	<div class="col-lg-6">
		@if (session()->has('amend') && session()->get('amend') == 'Y' && 1==1)
			{{-- {!! HTML::linkAction('UsersController@postAmendConfirmBooking', 'Amend', array($booking->booking_id), array('class' => 'btn btn-danger form-control', 'name' => 'amend')) !!} --}}
			{!! Form::submit('Amend', ['class' => 'btn btn-danger form-control', 'name' => 'amend']) !!}
		@endif
	</div>
</div>
</fieldset>

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
    		stepping: 10,
    		minDate: moment()
    		//locale: moment.local('el')
	    });
        $('#datetimepicker2').datetimepicker({
	        //format: 'YYYY-MM-DD H:mm',
	        format: 'DD/MM/YYYY H:mm',
    		extraFormats: [ 'YYYY-MM-DD H:mm' ],
    		stepping: 10,
    		minDate: moment()
	    });
	    $("#datetimepicker1").on("dp.change", function (e) {
            $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker2").on("dp.change", function (e) {
            $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>