@extends('fulllayout')

@section('content')

	<h1>Affiliates</h1>

	<table class="table table-condensed table-striped table-hover">
		<thead>
			<tr>
			  <th><small>#</small></th>
			  <th><small>First name</small></th>
			  <th><small>Last name</small></th>
			  <th><small>E-mail</small></th>
			  <th><small>Landline</small></th>
			  <th><small>Mobile</small></th>
			  <th><small>Referrer URL</small></th>
			  <th><small>Tracking Link</small></th>
			  <th><small>Actions</small></th>
			  
			  <th></th>

			</tr>
		</thead>
		<tbody>
	  	@foreach ($affiliates as $affiliate)
			<tr>
				<td></td>
				<td><small>{{ $affiliate->firstname }}</small></td>
				<td><small>{{ $affiliate->lastname }}</small></td>
				<td><small>{{ $affiliate->email }}</small></td>
				<td><small>{{ $affiliate->landline }}</small></td>
				<td><small>{{ $affiliate->mobile }}</small></td>
				<td><small>
					{{ $affiliate->referrer }} 
				</small></td>	
				<td><small>
					@if($affiliate->referrer)
						/noaf={{$affiliate->affiliate_id}}&ref={{$affiliate->referrer}}
					@endif
				</small></td>

				<td><a href="/partners/{{ $affiliate->affiliate_id }}/edit" class="btn btn-primary btn-xs">Edit</a>
					<a href="#" class="btn btn-danger btn-xs">Delete</a></td>
			</tr>
		@endforeach
		</tbody>
	</table>

	<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>

	<?php echo $affiliates->render(); ?>

@stop