<form class="form-horizontal">
	<fieldset>

		<div class="form-group">
			<div class="col-lg-6">
                {!! Form::label('name', 'Tag name:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-lg-6">
				{!! Form::label('icon_filename', 'Filename:') !!}
				{!! Form::file('icon_filename', null) !!}
    		</div>

    	</div>
    	<br/><br/><br/><br/>
    	<div class="form-group">
    		<div class="col-lg-8">
    			&nbsp;
    		</div>
    		<div class="col-lg-4">
    			{!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
    		</div>
    	</div>

    
  	</fieldset>
</form>