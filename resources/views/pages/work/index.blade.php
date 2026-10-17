@extends('layouts.app')
@section('content')
@include('components.page-intro', ['eyebrow' => 'Selected work', 'heading' => 'The problem. The thinking. The work.', 'intro' => 'Project stories should show what actually happened: the problem, the work, and what changed. We publish them with the people involved.'])
<section class="mx-auto max-w-[1320px] px-5 py-20 sm:px-8 lg:px-12">
    @forelse($projects as $project)
    <a href="{{ route('work.show', $project['slug']) }}" class="grid gap-7 border-t border-line py-10 sm:grid-cols-2">
        @if(!empty($project['image']))<img src="{{ asset($project['image']) }}" alt="{{ $project['alt'] }}" width="{{ $project['width'] }}" height="{{ $project['height'] }}" class="w-full rounded-xl" loading="lazy">@endif
        <div><p class="font-mono text-[11px] uppercase tracking-widest text-muted">{{ $project['type'] }}</p><h2 class="mt-5 text-[36px] font-medium tracking-tight">{{ $project['title'] }}</h2><p class="mt-5 text-muted">{{ $project['summary'] }}</p><span class="mt-7 inline-block text-accent">Read the story ↗</span></div>
    </a>
    @empty
    <div class="grid gap-10 rounded-[18px] border border-dashed border-ink/20 p-8 sm:grid-cols-[1fr_1.2fr] sm:p-14"><p class="font-hand text-[28px] text-moss">Good work takes care.<br>So does telling its story.</p><div><h2 class="text-[32px] font-medium leading-tight tracking-tight">Project stories are on the way.</h2><p class="mt-5 max-w-[500px] text-[18px] leading-relaxed text-muted">We’re preparing work to share. If you’re wondering how we might approach your project, let’s start with a conversation.</p><a href="/contact" class="mt-7 inline-flex min-h-11 items-center gap-5 border-b border-ink/30">Tell us what you need <span aria-hidden="true">↗</span></a></div></div>
    @endforelse
</section>
@include('components.home.process')
@include('components.cta')
@endsection
