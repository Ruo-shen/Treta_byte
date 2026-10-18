@extends('layouts.app')
@section('content')
@php $empty = count($projects) === 0; @endphp
<x-inner.header :variant="$empty ? 'split' : 'editorial'" kicker="Work / The project files" lede="A useful case study explains the problem, the decisions and what actually changed. We share the detail with the people involved.">
    <x-slot:title>The thinking<br><span class="text-moss">behind the work.</span></x-slot:title>
    @if($empty)
        <x-inner.sketch class="mx-auto max-w-[460px] lg:mx-0 lg:ml-auto">
            <div class="relative mx-auto aspect-[1.3] w-full max-w-[340px]" aria-hidden="true">
                <span class="absolute left-[6%] top-[4%] h-[14%] w-[34%] rounded-t-[10px] border border-b-0 border-[#c9c5b8] bg-[#ddd8c9]"></span>
                <div class="absolute inset-x-0 bottom-0 top-[16%] -rotate-3 rounded-[10px] rounded-tl-none border border-[#c9c5b8] bg-[#e6e2d5] shadow-[0_28px_38px_-30px_rgba(23,25,27,0.5)]">
                    <span class="absolute left-5 top-5 font-mono text-[12px] tracking-[0.18em] text-moss">PROJECT NOTES</span>
                    <span class="absolute inset-x-5 top-14 h-px bg-ink/15"></span>
                    <span class="absolute inset-x-5 top-[4.6rem] h-px bg-ink/15"></span>
                    <span class="absolute inset-x-5 top-[5.7rem] h-px w-1/2 bg-ink/15"></span>
                    <span class="absolute left-5 top-[7.6rem] text-[15px] text-muted">Ready when the story is.</span>
                </div>
            </div>
            <x-slot:note>The story matters<br>as much as the screenshot.</x-slot:note>
        </x-inner.sketch>
    @endif
</x-inner.header>

<x-inner.band id="archive" kicker="Project archive">
    @if($empty)
        <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:gap-16">
            <h2 class="text-[clamp(1.9rem,5.5vw,3.2rem)] font-medium leading-[1.1] tracking-[-0.035em]">Our project files<br>are being prepared.</h2>
            <div>
                <p class="max-w-[520px] text-[17px] leading-[1.65] text-muted">Nothing to publish here just yet. We’ll share work once the details and permission are ready. In the meantime, we can talk about what your project needs.</p>
                <x-inner.button :href="route('contact.show')" variant="link" class="mt-4">Discuss a project</x-inner.button>
                <x-inner.placeholder class="mt-8" what="approved project cards (image, service, title, summary), added in config/work.php once the client has approved publication" />
            </div>
        </div>
    @else
        <ul class="grid gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($projects as $projectSlug => $project)
                @php $serviceName = config('services.offerings.'.($project['service'] ?? '').'.name'); @endphp
                <li>
                    <article class="group relative">
                        @if(!empty($project['image']))
                            <img src="{{ asset($project['image']) }}" alt="{{ $project['image_alt'] ?? '' }}" width="{{ $project['image_width'] ?? 1200 }}" height="{{ $project['image_height'] ?? 750 }}" loading="lazy" class="aspect-[16/10] h-auto w-full rounded-[12px] border border-line bg-soft object-cover">
                        @else
                            <div class="aspect-[16/10] rounded-[12px] border border-line bg-soft" aria-hidden="true"></div>
                        @endif
                        <x-inner.kicker class="mt-5">{{ $serviceName ?? 'Project story' }}</x-inner.kicker>
                        <h2 class="mt-2 text-[26px] font-medium leading-[1.12] tracking-[-0.025em]">
                            <a href="{{ route('work.show', $projectSlug) }}" class="block py-1 after:absolute after:inset-0 after:content-['']">{{ $project['title'] }}</a>
                        </h2>
                        <p class="mt-3 text-[16px] leading-[1.6] text-muted">{{ $project['summary'] }}</p>
                        <p class="mt-4 inline-flex min-h-11 items-center gap-2 text-[15px] font-medium" aria-hidden="true">Read the story <span class="text-accent">↗</span></p>
                    </article>
                </li>
            @endforeach
        </ul>
    @endif
</x-inner.band>

<x-inner.band tone="soft" kicker="What you’ll find in a story">
    <x-slot:heading>More than<br>a finished screen.</x-slot:heading>
    <x-inner.facts layout="grid" :items="[
        ['01 / The situation', 'What needed to work, and what was getting in the way.'],
        ['02 / The decisions', 'What we chose to do, and the tradeoffs behind it.'],
        ['03 / The result', 'What was delivered, with only outcomes we can verify.'],
    ]" />
</x-inner.band>

<x-inner.cta label="Discuss a project" body="Start with what you know. We’ll ask the useful questions.">
    <x-slot:heading>Let’s talk about<br><span class="text-[#a7b3a6]">what your project needs.</span></x-slot:heading>
</x-inner.cta>
@endsection
