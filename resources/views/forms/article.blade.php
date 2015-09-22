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

        <br/><br/><br/>
        <div class="form-group">
            <div class="col-lg-12">
                {!! Form::label('body', 'Body:') !!}
                {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    	
    	<div class="form-group">
    		<div class="col-lg-10">
    			&nbsp;
    		</div>
    		<div class="col-lg-2">
                <br/>
    			{!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
    		</div>
    	</div>

    
  	</fieldset>
</form>