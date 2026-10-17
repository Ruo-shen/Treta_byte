{{-- BACKEND STUB: replace. Data: $posts (paginator of published posts), $categories. --}}
@extends('_stubs.layout')
@section('content')
<h1>Blog</h1>
@foreach ($posts as $post)<a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>@endforeach
{{ $posts->links() }}
@endsection
