<form class="form-horizontal">
	<fieldset>

		<div class="form-group">
			<div class="col-lg-6">
				{!! Form::label('name', 'Location name:') !!}
				{!! Form::text('name', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-4">
				{!! Form::label('location_parent_id', 'Parent location:') !!}
				{!! Form::select('location_parent_id', $parents, null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-2">
				{!! Form::label('status', 'Status:') !!}
				{!! Form::select('status', ['A' => 'Active',
				   							'I' => 'Inactive'], null, ['class' => 'form-control']) !!}
    		</div>

    	</div>
    	<br/><br/><br/>
    	<div class="form-group">
			<div class="col-lg-3">
				{!! Form::label('lat', 'Latitude:') !!}
				{!! Form::text('lat', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-3">
				{!! Form::label('lng', 'Longtitude:') !!}
				{!! Form::text('lng', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-4">
				{!! Form::label('currency', 'Currency:') !!}
				{!! Form::text('currency', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-2">
				{!! Form::label('currency_order', 'Currency order:') !!}
				{!! Form::select('currency_order', ['L' => 'Left',
				   									'R' => 'Right'], null, ['class' => 'form-control']) !!}
    		</div>
    	</div>
        <br/><br/><br/>
        <div class="form-group">
            <div class="col-lg-12">
                {!! Form::label('description', 'Description:') !!}
                {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    	<br/><br/><br/><br/>
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