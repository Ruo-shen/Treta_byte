{{-- BACKEND STUB: replace. Data: $post, $preview (bool). Render body only via $post->contentHtml() (sanitized). --}}
@extends('_stubs.layout')
@section('content')
@if ($preview)<p>Preview: {{ $post->status->getLabel() }}</p>@endif
<h1>{{ $post->title }}</h1>
<article>{!! $post->contentHtml() !!}</article>
@endsection
