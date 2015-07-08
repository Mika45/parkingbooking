@extends('booklayout')

@section('content')

	<h1>Tags</h1>

	<table class="table table-condensed table-striped table-hover">
		<thead>
			<tr>
			  <th><small>#</small></th>
			  <th><small>Name</small></th>
			  <th><small>Icon</small></th>
			  <th><small>Filename</small></th>
			  <th></th>
			  <th></th>
			</tr>
		</thead>
		<tbody>
	  	@foreach ($tags as $tag)
			<tr>
				<td></td>
				<td><small>{{ $tag->name }}</small></td>
				<td><small><img src='/img/icons/{{ $tag->icon_filename }}' /></small></td>
				<td><small>{{ $tag->icon_filename }}</small></td>
				<td><a href="/tags/{{ $tag->tag_id }}/edit" class="btn btn-primary btn-xs">Edit</a></td>
				<td><a href="/translations/tag/{{ $tag->tag_id }}" class="btn btn-success btn-xs">Edit Translation</a></td>
			</tr>
		@endforeach
		</tbody>
	</table>

	<?php echo $tags->render(); ?>

@stop