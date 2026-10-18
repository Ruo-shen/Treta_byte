@extends('layouts.app')
@section('content')
<article>
    <header class="mx-auto max-w-[1000px] px-5 pb-12 pt-36 sm:px-8 sm:pt-44">
        <a href="{{ route('blog.index') }}" class="inline-flex min-h-11 items-center text-[14px] text-muted">← Back to the journal</a>
        @if($preview ?? false)<p role="status" class="mb-6 font-mono text-[11px] uppercase tracking-widest text-muted">Preview — not published</p>@endif
        <p class="mt-8 font-mono text-[11px] uppercase tracking-widest text-accent">@if($post->category){{ $post->category->name }}@if($post->published_at) · @endif @endif @if($post->published_at)<time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('j M Y') }}</time>@endif</p>
        <h1 class="mt-6 text-[clamp(2.6rem,5vw,4.6rem)] font-medium leading-[1.06] tracking-[-0.04em]">{{ $post->title }}</h1>
        <p class="mt-7 max-w-[780px] text-[21px] leading-relaxed text-muted">{{ $post->excerpt }}</p>
    </header>
    @if($featuredImage)
    <figure class="mx-auto max-w-[1200px] px-5 sm:px-8"><img src="{{ $featuredImage['url'] }}" alt="{{ $post->featured_image_alt }}" width="{{ $featuredImage['width'] }}" height="{{ $featuredImage['height'] }}" class="h-auto w-full rounded-xl"></figure>
    @endif
    {{-- The backend supplies sanitized article HTML; never pass untrusted rich-editor output directly. --}}
    <div class="article-content mx-auto max-w-[800px] px-5 py-14 sm:px-8 sm:py-20">{!! $contentHtml !!}</div>
</article>
@include('components.cta')
@endsection
