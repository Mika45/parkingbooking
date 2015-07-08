@extends('fulllayout')

@section('content')

	<table class="table table-condensed table-striped table-hover">
		<thead>
			<tr>
			  <th><small>#</small></th>
			  <th><small>Field name</small></th>
			  <th><small>Type</small></th>
			  <th><small>Attributes</small></th>
			  <th><small>Label</small></th>
			  <th><small></small></th>
			</tr>
		</thead>
		<tbody>
	  	@foreach ($fields as $field)
			<tr>
				<td></td>
				<td><small>{{ $field->field_name }}</small></td>
				<td><small>{{ $field->type }}</small></td>
				<td><small>{{ $field->attributes }}</small></td>
				<td><small>{{ $field->label }}</small></td>
				<td><a href="/fields/{{ $field->field_id }}/edit" class="btn btn-primary btn-xs">Edit</a></td>				
			</tr>
		@endforeach
		</tbody>
	</table>

@stop