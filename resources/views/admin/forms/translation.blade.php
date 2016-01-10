<div class="box-body">
    <form class="form-horizontal">
        <fieldset>
            <div class="form-group">
                <div class="col-lg-3">
                    {!! Form::label('locale', 'Locale:') !!}
                    {!! Form::select('locale', $langs, null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-3">
                    {!! Form::label('column_name', 'Column:') !!}
                    {!! Form::select('column_name', $columns, null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-6">
                    {!! Form::label('value', 'Value:') !!}
                    {!! Form::textarea('value', null, ['class' => 'form-control']) !!}
                </div>

                {!! Form::hidden('table_name', $table_name) !!}
                {!! Form::hidden('identifier', $identifier) !!}
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