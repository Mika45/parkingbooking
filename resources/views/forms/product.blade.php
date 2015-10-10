<form class="form-horizontal">
	<fieldset>

		<div class="form-group">
			<div class="col-lg-4">
                {!! Form::label('name', 'Product name:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-lg-2">
                {!! Form::label('price', 'Price:') !!}
                {!! Form::text('price', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-lg-6">
				{!! Form::label('description', 'Description:') !!}
                {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    		</div>

    	</div>
    	
    	<div class="form-group">
    		<div class="col-lg-8">

    		</div>
    		<div class="col-lg-4">
                <br/>
    			{!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
    		</div>
    	</div>

    
  	</fieldset>
</form>