@extends('templates.admin')

@section('content')

<div class="row">
   <div class="col-xs-12">
     	<div class="box">
			<div class="box-header">
				@if (isset($box_title))<h3 class="box-title">{{ $box_title or null }}</h3><br/>@endif
         	<a href="/admin/translations/{{ $type }}/{{ $identifier }}/create" class="btn btn-primary btn-xs">Add translation</a>
       	</div><!-- /.box-header -->
			<div class="box-body">
				<table id="tags" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th><small>Locale</small></th>
							<th><small>Column</small></th>
							<th><small>Value</small></th>
							<th><small></small></th>
							<th><small></small></th>
						</tr>
					</thead>
					<tbody>
				  		@foreach ($translations as $translation)
						<tr>
							<td><small>{{ $translation->locale }}</small></td>
							<td><small>{{ $translation->column_name }}</small></td>
							<td><small>{{ $translation->value }}</small></td>
							<td><a href="/admin/translations/{{ $translation->translation_id }}/edit" class="btn btn-primary btn-xs">Edit</a></td>
							<td><a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#basicModal{{$translation->translation_id}}">Delete</a></td>

							<div class="modal fade" id="basicModal{{$translation->translation_id}}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
							    <div class="modal-dialog">
							        <div class="modal-content">
							            <div class="modal-header">
								            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								            <h4 class="modal-title" id="myModalLabel">Delete Translation</h4>
							            </div>
							            <div class="modal-body">
							                <p>Are you sure you want to delete this translation?</p>
							            </div>
							            <div class="modal-footer">
							                
							                {!! Form::open(['method' => 'DELETE', 'route' => ['translations.destroy', $translation->translation_id]]) !!}
							                		<button type="button" class="btn btn-default" data-dismiss="modal">No</button>	
							                		{!! Form::submit('Yes', ['class' => 'btn btn-default']) !!}
							                {!! Form::close() !!}
							        	</div>
							    </div>
							  </div>
							</div>

						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@stop