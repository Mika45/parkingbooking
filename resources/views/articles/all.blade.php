@extends('layout')

@section('title')
    {{Lang::get('site.page_news')}}
@stop

@section('sidebar')

@stop

@section('content')

	<h1>{{ Lang::get('site.page_news') }}</h1>

	@foreach ($articles as $article)

		@if ($article->slug)
			<h2><a href="/{{App::getLocale()}}/news/{{$article->slug}}">{{ $article->title }}</a></h2>
		@else
			<h2>{{ $article->title }}</h2>
		@endif

		<p>{!! $article->body !!}</p>

	@endforeach

@stop