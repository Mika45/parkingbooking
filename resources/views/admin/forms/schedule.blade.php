<div class="box-body">
    <form class="form-horizontal">
      <fieldset>

        <div class="form-group">
          <div class="col-lg-3">
                    {!! Form::label('day', 'Day:') !!}
                    {!! Form::select('day', [
                       '2' => 'Monday',
                       '3' => 'Tuesday',
                       '4' => 'Wednesday',
                       '5' => 'Thursday',
                       '6' => 'Friday',
                       '7' => 'Saturday',
                       '1' => 'Sunday'], null, ['class' => 'form-control']
                    ) !!}
            </div>
            <div class="col-lg-3">
            {!! Form::label('from_hour', 'From hour:') !!}
            {!! Form::text('from_hour', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-lg-3">
            {!! Form::label('to_hour', 'To hour:') !!}
            {!! Form::text('to_hour', null, ['class' => 'form-control']) !!}
            </div>
                <div class="col-lg-3">
                    {!! Form::label('driving', 'Type:') !!}
                    {!! Form::select('driving', [
                       'IO' => 'Check-in and Check-out',
                       'I'  => 'Check-in',
                       'O'  => 'Check-out'], null, ['class' => 'form-control']
                    ) !!}
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