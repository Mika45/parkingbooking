@extends('layout')

@section('title')
    {{Lang::get('site.page_news')}}
@stop

@section('sidebar')

@stop

@section('content')

	<h1>{{ Lang::get('site.page_news') }}</h1>

	{{-- @foreach ($article as $art) --}}

		<h2>{{ $article->title }}</h2>
		<p>{!! $article->body !!}</p>

	{{-- @endforeach --}}

@stop