<br/>
<fieldset class="user-settings-answer">

	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<div class="form-group">
		<label for="email" class="col-lg-4 control-label">* {{ Lang::get('site.reg_email') }}</label>
		<div class="col-lg-8">
			{!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email', 'disabled' => 'disabled', 'readonly']) !!}
		</div>
	</div>
	<div class="form-group">
		<label for="firstname" class="col-lg-4 control-label">* {{ Lang::get('site.reg_firstname') }}</label>
		<div class="col-lg-8">
			{!! Form::text('firstname', null, ['class' => 'form-control', 'id' => 'firstname', 'disabled' => 'disabled']) !!}
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-lg-4 control-label">* {{ Lang::get('site.reg_lastname') }}</label>
		<div class="col-lg-8">
			{!! Form::text('lastname', null, ['class' => 'form-control', 'id' => 'lastname', 'disabled' => 'disabled']) !!}
		</div>
	</div>
	<div class="form-group">
		<label for="mobile" class="col-lg-4 control-label">* {{ Lang::get('site.reg_mobile') }}</label>
		<div class="col-lg-8">
			{!! Form::text('mobile', null, ['class' => 'form-control', 'id' => 'mobile', 'disabled' => 'disabled']) !!}
		</div>
	</div>
	<div class="form-group">
		<label for="car_make" class="col-lg-4 control-label">{{ Lang::get('site.reg_car_make') }}</label>
		<div class="col-lg-8">
			{!! Form::text('car_make', null, ['class' => 'form-control', 'id' => 'car_make', 'disabled' => 'disabled']) !!}
		</div>
	</div>
	<div class="form-group">
		<label for="car_model" class="col-lg-4 control-label">{{ Lang::get('site.reg_car_model') }}</label>
		<div class="col-lg-8">
			{!! Form::text('car_model', null, ['class' => 'form-control', 'id' => 'car_model', 'disabled' => 'disabled']) !!}
		</div>
	</div>
	<div class="form-group">
		<label for="car_reg" class="col-lg-4 control-label">{{ Lang::get('site.reg_car_reg') }}</label>
		<div class="col-lg-8">
			{!! Form::text('car_reg', null, ['class' => 'form-control', 'id' => 'car_reg', 'disabled' => 'disabled']) !!}
		</div>
	</div>
	<div class="form-group">
		<label for="car_colour" class="col-lg-4 control-label">{{ Lang::get('site.reg_car_colour') }}</label>
		<div class="col-lg-8">
			{!! Form::text('car_colour', null, ['class' => 'form-control', 'id' => 'car_colour', 'disabled' => 'disabled']) !!}
		</div>
	</div>


	<div class="form-group">
		<div class="col-lg-8 col-lg-offset-4">
			{!! Form::submit(Lang::get('site.form_save'), ['class' => 'btn btn-primary form-control', 'id' => 'save', 'disabled' => 'disabled']) !!}
		</div>
	</div>

</fieldset>

<fieldset class="user-settings-question">
    {!! Form::checkbox('user-settings', 0, null, ['id' => 'user-settings', 'onChange' => 'valueChanged()']) !!}
    {!! Form::label('user-settings', 'Edit') !!}
</fieldset>

<script>
	function valueChanged() {
		/*
		if ($('#user-settings').is(':checked')) {
		    $(".user-settings-answer").hide();
		} else {
		    $(".user-settings-answer").show();
		}*/

		/*
		if ($('#user-settings').is(':checked')) {
			$('input').each(function() {
	            if ($(this).attr('disabled')) {
	                $(this).removeAttr('disabled');
	            }
	            else {
	                $(this).attr({
	                    'disabled': 'disabled'
	                });
	            }
	        });
	    }
	    */

	    if ($('#user-settings').is(':checked')) {
		    //document.getElementById("email").disabled = false;
		    document.getElementById("firstname").disabled = false;
		    document.getElementById("lastname").disabled = false;
		    document.getElementById("save").disabled = false;
		    document.getElementById("mobile").disabled = false;
		    document.getElementById("car_make").disabled = false;
		    document.getElementById("car_model").disabled = false;
		    document.getElementById("car_reg").disabled = false;
		    document.getElementById("car_colour").disabled = false;
		} else {
		    //document.getElementById("email").disabled = true;
		    document.getElementById("firstname").disabled = true;
		    document.getElementById("lastname").disabled = true;
		    document.getElementById("save").disabled = true;
		    document.getElementById("mobile").disabled = true;
		    document.getElementById("car_make").disabled = true;
		    document.getElementById("car_model").disabled = true;
		    document.getElementById("car_reg").disabled = true;
		    document.getElementById("car_colour").disabled = true;
		}

	}
</script>