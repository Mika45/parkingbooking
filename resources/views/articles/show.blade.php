@extends('layout')

@section('title')
    {{Lang::get('site.page_news')}}
@stop

@section('sidebar')

@stop

@section('content')

	<h1>{{ Lang::get('site.page_news') }}</h1>

	@foreach ($articles as $article)

		<h2>{{$article->title}}</h2>
		<p>{{$article->body}}</p>

	@endforeach

@stop