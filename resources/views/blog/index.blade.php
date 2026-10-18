@extends('layouts.app')
@section('content')
@php
    $featured = $posts->currentPage() === 1 ? $posts->first() : null;
    $rest = $featured ? $posts->slice(1) : $posts;
    $featuredImage = $featured?->featuredImage();
@endphp
<x-inner.header variant="editorial" kicker="The journal" lede="Notes on websites, systems, and the practical work of keeping technology useful.">
    <x-slot:title>A little clarity<br><span class="text-moss">goes a long way.</span></x-slot:title>
    @if($categories->isNotEmpty())
        <x-inner.chips label="Categories" :items="array_merge(
            [['All', route('blog.index'), ! $activeCategory]],
            $categories->map(fn ($category) => [$category->name, route('blog.index', ['category' => $category->slug]), (bool) $activeCategory?->is($category)])->all(),
        )" />
    @endif
</x-inner.header>

@if($posts->isEmpty())
    <x-inner.band>
        <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-center lg:gap-16">
            <x-inner.note tilt="left" class="max-w-[340px] p-8 text-[30px]">Something worth reading.<br>When it’s ready.</x-inner.note>
            <div>
                <h2 class="text-[clamp(1.9rem,5vw,2.8rem)] font-medium leading-[1.1] tracking-[-0.035em]">Our first notes are on the way.</h2>
                <p class="mt-5 max-w-[500px] text-[17px] leading-[1.65] text-muted">There are no articles to share just yet. If you have a question about a website or system, you can ask us directly.</p>
                <x-inner.button :href="route('contact.show')" variant="link" class="mt-4">Start a conversation</x-inner.button>
            </div>
        </div>
    </x-inner.band>
@else
    <x-inner.band class="pb-8! sm:pb-10! lg:pb-12!">
        @if($featured)
            <article class="group relative grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center lg:gap-14">
                @if($featuredImage)
                    <img src="{{ $featuredImage['url'] }}" alt="{{ $featured->featured_image_alt }}" width="{{ $featuredImage['width'] }}" height="{{ $featuredImage['height'] }}" class="aspect-[16/10] h-auto w-full rounded-[14px] border border-line bg-soft object-cover">
                @else
                    <div class="relative aspect-[16/10] overflow-hidden rounded-[14px] bg-mist p-6 sm:p-8" aria-hidden="true">
                        <svg class="pointer-events-none absolute bottom-0 right-0 h-[80%] w-auto" viewBox="0 0 360 340" fill="none" preserveAspectRatio="xMaxYMax meet"><path d="M10 340 A170 170 0 0 1 340 160" stroke="#4c6656" stroke-opacity="0.35" /><path d="M145 340 V30 H250 V168 H360" stroke="#4c6656" stroke-opacity="0.35" /><rect x="250" y="0" width="30" height="30" fill="#315ceb" /></svg>
                        <p class="relative font-mono text-[12px] uppercase tracking-[0.16em] text-moss">{{ $featured->category?->name ?? 'The journal' }}</p>
                        <p class="relative mt-6 text-[clamp(3.5rem,9vw,6rem)] font-light leading-none tracking-[-0.05em] text-ink/80">{{ $featured->published_at->format('j M') }}</p>
                        <p class="relative mt-2 font-mono text-[13px] text-moss">{{ $featured->published_at->format('Y') }}</p>
                    </div>
                @endif
                <div>
                    <p class="font-mono text-[12px] uppercase leading-relaxed tracking-[0.14em] text-muted">Latest · @if($featured->category){{ $featured->category->name }} · @endif<time datetime="{{ $featured->published_at->toDateString() }}">{{ $featured->published_at->format('j M Y') }}</time> · {{ $featured->reading_time }} min read</p>
                    <h2 class="mt-4 text-[clamp(1.9rem,4.5vw,3rem)] font-medium leading-[1.08] tracking-[-0.035em]">
                        <a href="{{ route('blog.show', $featured->slug) }}" class="flex min-h-11 items-center after:absolute after:inset-0 after:content-['']">{{ $featured->title }}</a>
                    </h2>
                    <p class="mt-4 max-w-[560px] text-[17px] leading-[1.65] text-muted">{{ $featured->excerpt }}</p>
                    <p class="mt-5 inline-flex min-h-11 items-center gap-2 text-[15px] font-medium" aria-hidden="true">Read the article <span class="text-accent">↗</span></p>
                </div>
            </article>
        @endif
        @if($rest->isNotEmpty())
            @unless($featured)<h2 class="sr-only">Articles</h2>@endunless
            <ul class="{{ $featured ? 'mt-14 border-t border-ink/15 pt-12' : '' }} grid gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($rest as $post)
                    <li>@include('blog._card')</li>
                @endforeach
            </ul>
        @endif
        @if($posts->hasPages())
            <div class="mt-12">{{ $posts->links() }}</div>
        @endif
    </x-inner.band>
@endif

<x-inner.cta />
@endsection
