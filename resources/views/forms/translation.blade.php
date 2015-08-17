<form class="form-horizontal">
	<fieldset>

		
		<div class="form-group">
        @if ( $type == 'parking' )
			<div class="col-lg-3">
				{!! Form::label('locale', 'Locale:') !!}
				{!! Form::select('locale', $langs, null, ['class' => 'form-control']) !!}
    		</div>
			<div class="col-lg-3">
				{!! Form::label('column_name', 'Column:') !!}
				{!! Form::select('column_name', ['description' => 'Description',
				   								 'reserve_notes' => 'Reserve notes',
				   								 'find_it' => 'Find it',
                                                 'address' => 'Address'], null, ['class' => 'form-control']) !!}
    		</div>

    		
    		<div class="col-lg-6">
				{!! Form::label('value', 'Value:') !!}
				{!! Form::textarea('value', null, ['class' => 'form-control']) !!}
    		</div>

            {!! Form::hidden('table_name', 'PARKING') !!}
            {!! Form::hidden('identifier', $parking->parking_id) !!}  	
    	
        @elseif ( $type == 'location' )

    	   <div class="col-lg-3">
                {!! Form::label('locale', 'Locale:') !!}
                {!! Form::select('locale', $langs, null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-lg-3">
                {!! Form::label('column_name', 'Column:') !!}
                {!! Form::select('column_name', ['description' => 'Description', 'location_page_name' => 'Location Page title', 'name' => 'Name', 'slug' => 'URL alias'], null, ['class' => 'form-control']) !!}
            </div>

            
            <div class="col-lg-6">
                {!! Form::label('value', 'Value:') !!}
                {!! Form::textarea('value', null, ['class' => 'form-control']) !!}
            </div>

            {!! Form::hidden('table_name', 'LOCATION') !!}
            {!! Form::hidden('identifier', $location->location_id) !!} 

        @elseif ( $type == 'tag' )

           <div class="col-lg-3">
                {!! Form::label('locale', 'Locale:') !!}
                {!! Form::select('locale', $langs, null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-lg-3">
                {!! Form::label('column_name', 'Column:') !!}
                {!! Form::select('column_name', ['name' => 'Name'], null, ['class' => 'form-control']) !!}
            </div>

            
            <div class="col-lg-6">
                {!! Form::label('value', 'Value:') !!}
                {!! Form::text('value', null, ['class' => 'form-control']) !!}
            </div>

            {!! Form::hidden('table_name', 'TAG') !!}
            {!! Form::hidden('identifier', $tag->tag_id) !!} 

        @endif
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