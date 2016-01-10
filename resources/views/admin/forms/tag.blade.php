<div class="box-body">
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
      	</fieldset>
        &nbsp;
        <div class="box-footer">
            <div class="col-lg-10">
            </div>
            <div class="col-lg-2">
                {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
            </div>
        </div>
    </form>
</div>