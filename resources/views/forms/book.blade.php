<div class="form-group">

	<!-- {!! Form::text('location', Input::old('location'), ['class' => 'form-control']) !!} -->
	{!! Form::label('location', 'Location:') !!}
	{!! Form::select('location', $locationsList, null, ['class' => 'form-control']) !!}
	{!! Form::label('checkin', 'Check-in:') !!}
	{!! Form::text('checkin', null, ['class' => 'form-control']) !!}
	{!! Form::label('checkout', 'Check-out:') !!}
	{!! Form::text('checkout', null, ['class' => 'form-control']) !!}

</div>

<div class="form-group">
	{!! Form::submit('Search', ['class' => 'btn btn-primary form-control']) !!}
</div>

<script type="text/javascript">
	$('select').select2();
	$(document).ready(function() {
  		$(".js-example-basic-single").select2();
	});
</script>