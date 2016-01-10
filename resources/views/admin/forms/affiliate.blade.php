<div class="box-body">
    <form class="form-horizontal">
    	<fieldset>

    		<div class="form-group">
    			<div class="col-lg-3">
    				{!! Form::label('firstname', 'First name:') !!}
    				{!! Form::text('firstname', null, ['class' => 'form-control']) !!}
        		</div>
                <div class="col-lg-3">
                    {!! Form::label('lastname', 'Last name:') !!}
                    {!! Form::text('lastname', null, ['class' => 'form-control']) !!}
                </div>
        		<div class="col-lg-4">
    				{!! Form::label('email', 'E-mail:') !!}
    				{!! Form::text('email', null, ['class' => 'form-control']) !!}
        		</div>
        		<div class="col-lg-2">
    				{!! Form::label('status', 'Status:') !!}
    				{!! Form::select('status', ['A' => 'Active', 'I' => 'Inactive'], null, ['class' => 'form-control']) !!}
        		</div>
        	</div>

        	&nbsp;
            
            <div class="form-group">
                <div class="col-lg-3">
                    {!! Form::label('landline', 'Landline:') !!}
                    {!! Form::text('landline', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-3">
                    {!! Form::label('mobile', 'Mobile:') !!}
                    {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-6">
                    {!! Form::label('referrer', 'Referrer:') !!}
                    {!! Form::text('referrer', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            &nbsp;

            <div class="form-group">
                <div class="col-lg-12">
                    {!! Form::label('comments', 'Comments:') !!}
                    {!! Form::textarea('comments', null, ['class' => 'form-control']) !!}
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