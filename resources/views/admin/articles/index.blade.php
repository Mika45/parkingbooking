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
					<table id="articles" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><small>Title</small></th>
								<th><small>URL</small></th>
								<th><small></small></th>
								<th><small>Published at</small></th>
								<th><small>Actions</small></th>
							</tr>
						</thead>
						<tbody>
					  		@foreach ($articles as $article)
							<tr>
								<td><small>{{ $article->title }}</small></td>
								<td><small>{{ $article->slug }}</td>
								<td>@if($article->slug) <a href="/{{App::getLocale()}}/news/{{ $article->slug }}" target="_blank" class="btn btn-primary btn-xs">View</a> @endif</td>
								<td><small>{{ $article->published_at }}</small></td>

								<td><a href="/admin/articles/{{ $article->article_id }}/edit" class="btn btn-primary btn-xs">Edit article</a>
									<a href="#" class="btn btn-danger btn-xs">Delete article</a>
									<a href="/admin/translations/article/{{ $article->article_id }}" class="btn btn-success btn-xs">Edit translation</a></td>
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
          $('#articles').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
          });
      } );
    </script>
    @parent
@stop