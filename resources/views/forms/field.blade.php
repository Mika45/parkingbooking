<form class="form-horizontal">
	<fieldset>

		<div class="form-group">
			<div class="col-lg-3">
                {!! Form::label('label', 'Field label:') !!}
                {!! Form::text('label', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-lg-3">
				{!! Form::label('field_name', 'Field name:') !!}
				{!! Form::text('field_name', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-2">
				{!! Form::label('type', 'Type:') !!}
				{!! Form::select('type', ['text'    => 'Text',
                                          'select'  => 'Select'], null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-4">
				{!! Form::label('attributes', 'Attributes:') !!}
				{!! Form::text('attributes', null, ['class' => 'form-control']) !!}
    		</div>

    	</div>
    	<br/><br/><br/><br/>
    	<div class="form-group">
    		<div class="col-lg-10">
    			&nbsp;
    		</div>
    		<div class="col-lg-2">
    			{!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
    		</div>
    	</div>

    
  	</fieldset>
</form>