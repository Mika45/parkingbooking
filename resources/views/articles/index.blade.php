@extends('fulllayout')

@section('content')

	<h1>Articles</h1>

	<table class="table table-condensed table-striped table-hover">
		<thead>
			<tr>
			  <th><small>#</small></th>
			  <th><small>Title</small></th>
			  <th><small>URL</small></th>
			  <th><small></small></th>
			  <th><small>Published at</small></th>
			  
			  <th></th>

			</tr>
		</thead>
		<tbody>
	  	@foreach ($articles as $article)
			<tr>
				<td></td>
				<td><small>{{ $article->title }}</small></td>
				<td><small>{{ $article->slug }}</td>
				<td>@if($article->slug) <a href="/{{App::getLocale()}}/news/{{ $article->slug }}" target="_blank" class="btn btn-primary btn-xs">View</a> @endif</td>
				<td><small>{{ $article->published_at }}</small></td>

				<td><a href="/articles/{{ $article->article_id }}/edit" class="btn btn-primary btn-xs">Edit article</a>
					<a href="#" class="btn btn-danger btn-xs">Delete article</a>
					<a href="/translations/article/{{ $article->article_id }}" class="btn btn-success btn-xs">Edit translation</a></td>
			</tr>
		@endforeach
		</tbody>
	</table>

	<?php echo $articles->render(); ?>

@stop