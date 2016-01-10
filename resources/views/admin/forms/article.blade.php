<div class="box-body">
    <form class="form-horizontal">
    	<fieldset>
    		<div class="form-group">
    			<div class="col-lg-6">
    				{!! Form::label('title', 'Title:') !!}
    				{!! Form::text('title', null, ['class' => 'form-control']) !!}
        		</div>
        		<div class="col-lg-6">
    				{!! Form::label('slug', 'URL:') !!}
                    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
        		</div>
        	</div>
            &nbsp;
            <div class="form-group">
                <div class="col-lg-12">
                    {!! Form::label('body', 'Body:') !!}
                    {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
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