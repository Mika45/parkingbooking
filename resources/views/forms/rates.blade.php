<form class="form-horizontal">
	<fieldset>

		<div class="form-group">
			<div class="col-lg-3">
                @if ( $parking->rate_type == 'D' )
    				{!! Form::label('day', 'Day:') !!}
    				{!! Form::text('day', null, ['class' => 'form-control']) !!}
                @elseif ( $parking->rate_type == 'H' )
                    {!! Form::label('hours', 'Hours:') !!}
                    {!! Form::text('hours', null, ['class' => 'form-control']) !!}
                @endif
    		</div>
    		<div class="col-lg-3">
				{!! Form::label('price', 'Price:') !!}
				{!! Form::text('price', null, ['class' => 'form-control']) !!}
    		</div>
    		<div class="col-lg-3">
				{!! Form::label('discount', 'Discount:') !!}
				{!! Form::text('discount', null, ['class' => 'form-control']) !!}
    		</div>
            <div class="col-lg-3">
                {!! Form::label('free_mins', 'Free minutes:') !!}
                {!! Form::text('free_mins', null, ['class' => 'form-control']) !!}
            </div>
    	</div>
    	<div class="form-group">
    		<div class="col-lg-10">
    		</div>
    		<div class="col-lg-2">
    			{!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
    		</div>
    	</div>

    
  	</fieldset>
</form>