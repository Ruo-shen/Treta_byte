@extends('layouts.app')
@section('content')
@include('components.page-intro', ['eyebrow' => 'The journal', 'heading' => 'A little clarity goes a long way.', 'intro' => 'Notes on websites, systems, and the practical work of keeping technology useful.'])
<section class="mx-auto max-w-[1320px] px-5 py-20 sm:px-8 lg:px-12">
    @forelse($posts as $post)
    <article class="grid gap-6 border-t border-line py-10 sm:grid-cols-[180px_1fr]">
        <div class="font-mono text-[11px] leading-loose text-muted">@if($post->category)<p>{{ $post->category->name }}</p>@endif<time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('j M Y') }}</time></div>
        <div><h2 class="max-w-[800px] text-[clamp(1.8rem,3vw,2.6rem)] font-medium leading-tight tracking-tight"><a href="{{ route('blog.show', $post->slug) }}" class="hover:text-accent">{{ $post->title }}</a></h2><p class="mt-5 max-w-[700px] text-[18px] leading-relaxed text-muted">{{ $post->excerpt }}</p></div>
    </article>
    @empty
    <div class="grid gap-8 border-y border-line py-14 sm:grid-cols-2"><p class="font-hand text-[30px] text-moss">Something worth reading.<br>When it’s ready.</p><div><h2 class="text-[30px] font-medium tracking-tight">Our first notes are on the way.</h2><p class="mt-4 max-w-[500px] text-[18px] leading-relaxed text-muted">There are no articles to share just yet. If you have a question about a website or system, you can ask us directly.</p><a href="/contact" class="mt-6 inline-flex min-h-11 items-center border-b border-ink/30">Start a conversation ↗</a></div></div>
    @endforelse
    <div class="mt-10">{{ $posts->links() }}</div>
</section>
@include('components.cta')
@endsection
