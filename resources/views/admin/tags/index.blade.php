@extends('templates.admin')

@section('content')

<div class="row">
   <div class="col-xs-12">
     	<div class="box">
			@if (isset($box_title))
			<div class="box-header">
         	<h3 class="box-title">{{ $box_title or null }}</h3>
       	</div><!-- /.box-header -->
       	@endif
			<div class="box-body">
				<table id="tags" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th><small>Name</small></th>
							<th><small>Icon</small></th>
							<th><small>Filename</small></th>
							<th><small>Actions</small></th>
						</tr>
					</thead>
					<tbody>
				  		@foreach ($tags as $tag)
						<tr>
							<td><small>{{ $tag->name }}</small></td>
							<td><small><img src='/img/icons/{{ $tag->icon_filename }}' /></small></td>
							<td><small>{{ $tag->icon_filename }}</small></td>
							<td><a href="/tags/{{ $tag->tag_id }}/edit" class="btn btn-primary btn-xs">Edit</a>
								 <a href="/translations/tag/{{ $tag->tag_id }}" class="btn btn-success btn-xs">Edit Translation</a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@stop

@section('plugins')
	<!-- Datatabels -->
   {!! HTML::script('js/admin/jquery.dataTables.min.js') !!}
	{!! HTML::script('js/admin/dataTables.bootstrap.min.js') !!}
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/bs/dt-1.10.10/datatables.min.css"/>
    @parent
@stop

@section('javascript')
    <script>
      $(document).ready(function() {
          $('#tags').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
          });
      } );
    </script>
    @parent
@stop