@extends('layouts.app')
@section('content')
<article class="overflow-x-clip bg-paper pt-[72px]">
    <header class="mx-auto w-full max-w-[1000px] px-5 pb-10 pt-6 sm:px-8 sm:pb-12 lg:pt-12">
        <x-inner.button :href="route('blog.index')" variant="link" :arrow="false">← Back to the journal</x-inner.button>
        @if($preview ?? false)
            <p role="status" class="mt-6 inline-block rounded-[6px] border border-dashed border-ink/30 px-3 py-2 font-mono text-[12px] uppercase tracking-widest text-muted">Preview — not published</p>
        @endif
        <p class="mt-8 font-mono text-[12px] uppercase leading-relaxed tracking-[0.14em] text-accent">
            @if($post->category){{ $post->category->name }} · @endif
            @if($post->published_at)<time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('j M Y') }}</time> · @endif
            {{ $post->reading_time }} min read
        </p>
        <h1 class="mt-5 text-[clamp(2.4rem,7vw,4.6rem)] font-medium leading-[1.06] tracking-[-0.04em]">{{ $post->title }}</h1>
        <p class="mt-6 max-w-[780px] text-[18px] leading-[1.6] text-muted sm:text-[21px]">{{ $post->excerpt }}</p>
    </header>
    @if($featuredImage)
        <figure class="mx-auto max-w-[1200px] px-5 sm:px-8">
            <img src="{{ $featuredImage['url'] }}" alt="{{ $post->featured_image_alt }}" width="{{ $featuredImage['width'] }}" height="{{ $featuredImage['height'] }}" class="h-auto w-full rounded-[14px]">
        </figure>
    @endif
    {{-- The backend supplies sanitized article HTML; never pass untrusted rich-editor output directly. --}}
    <x-inner.prose>{!! $contentHtml !!}</x-inner.prose>
</article>

@if($related->isNotEmpty())
    <x-inner.band tone="soft" kicker="Keep reading">
        <x-slot:heading>More from the journal.</x-slot:heading>
        <ul class="grid gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($related as $post)
                <li>@include('blog._card', ['related' => true])</li>
            @endforeach
        </ul>
    </x-inner.band>
@endif

<x-inner.cta />
@endsection
