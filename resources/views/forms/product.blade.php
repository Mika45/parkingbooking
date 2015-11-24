<form class="form-horizontal">
	<fieldset>

		<div class="form-group">
			<div class="col-lg-8">
                {!! Form::label('name', 'Product name:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-lg-4">
                {!! Form::label('price', 'Price:') !!}
                {!! Form::text('price', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <br/><br/><br/>
        <div class="form-group">
            <div class="col-lg-12">
				{!! Form::label('description', 'Description:') !!}
                {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    		</div>

    	</div>

        {!! Form::hidden('parking_id', $parking_id, array('id' => 'parking_id')) !!}
    	
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