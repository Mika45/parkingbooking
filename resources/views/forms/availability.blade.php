<form class="form-horizontal">
	<fieldset>


		<div class="form-group">

            <label for="datetimepicker1" class="col-lg-2 control-label">Monday</label>
    		<div class="col-lg-5">
                {!! Form::label('status', 'From:') !!}
				{!! Form::select('min_duration', [
                   '1' => '1', '2' => '2',
                   '3' => '3', '4' => '4',
                   '5' => '5', '6' => '6',
                   '7' => '7', '8' => '8',
                   '9' => '9', '10' => '10',
                   '11' => '11', '12' => '12',
                   '13' => '13', '14' => '14',
                   '15' => '15', '16' => '16',
                   '17' => '17', '18' => '18',
                   '19' => '19', '20' => '20',
                   '21' => '21', '22' => '22',
                   '23' => '23', '24' => '24'], null, ['class' => 'form-control', 'id' => 'from_hour']
                ) !!}
    		</div>
    		<div class="col-lg-5">
				{!! Form::label('status', 'Status:') !!}
				{!! Form::select('status', ['A' => 'Active',
				   							'I' => 'Inactive'], null, ['class' => 'form-control']) !!}
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