@extends('layout')

@section('title')
    {{Lang::get('site.page_news')}}
@stop

@section('sidebar')
	<h1>&nbsp;</h1>
	<img src="/img/news.png"/>
@stop

@section('content')

	<h1>{{ Lang::get('site.page_news') }}</h1>

	{{-- @foreach ($article as $art) --}}

		<h2>{!! $translations['title'] or $article->title !!}</h2>
		<h5>{{ date('d/m/Y', strtotime($article->published_at)) }}</h5>
		<p>{!! $translations['body'] or $article->body !!}</p>

	{{-- @endforeach --}}

@stop