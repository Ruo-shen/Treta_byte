@extends('layouts.app')
@section('content')
@php
    $pillars = [
        'fix' => ['01 / Fix', '“It used to work.”', 'Broken features, slow pages, failed connections. Find the cause and repair it properly.'],
        'build' => ['02 / Build', '“We need something better.”', 'A website that explains the business, or a custom tool that helps the team get things done.'],
        'care' => ['03 / Care', '“Who’s looking after this?”', 'Ongoing updates, maintenance and support. A clear arrangement with someone accountable.'],
    ];
@endphp
<x-inner.header variant="editorial" kicker="Services / A useful starting point" lede="Sometimes it’s a broken form. Sometimes it’s the whole system. We help you make sense of the problem, then do the work it needs.">
    <x-slot:title>What needs<br><span class="text-moss">to work better?</span></x-slot:title>
    <x-slot:actions>
        <x-inner.button href="#start" variant="link" :arrow="false">Find your starting point ↓</x-inner.button>
    </x-slot:actions>
</x-inner.header>

<x-inner.band id="start" kicker="Where are you starting from?">
    <x-slot:heading>You don’t need to know<br class="hidden sm:inline"> the technical answer.</x-slot:heading>
    <div>
        @foreach($pillars as $pillar => [$index, $question, $blurb])
            @php $items = array_filter($services, fn ($s) => $s['pillar'] === $pillar); $solo = count($items) === 1; @endphp
            <div class="grid gap-8 border-t border-ink/15 py-8 sm:py-10 lg:grid-cols-[0.75fr_1.25fr] lg:gap-14 lg:py-14">
                <div>
                    <p class="font-mono text-[12px] uppercase tracking-[0.14em] text-accent">{{ $index }}</p>
                    <h3 class="mt-4 text-[clamp(1.7rem,4vw,2.4rem)] font-medium leading-[1.1] tracking-[-0.03em]">{{ $question }}</h3>
                    <p class="mt-4 max-w-[420px] text-[16px] leading-[1.6] text-muted">{{ $blurb }}</p>
                </div>
                <div class="grid gap-5 {{ $solo ? '' : 'sm:grid-cols-2' }}">
                    @foreach($items as $serviceSlug => $item)
                        <article class="group relative flex flex-col gap-5 rounded-[14px] border border-line bg-white p-5 transition-colors hover:border-ink/30 sm:p-6 {{ $solo ? 'sm:flex-row sm:items-center sm:gap-8' : '' }}">
                            <div class="rounded-[10px] bg-soft p-4 {{ $solo ? 'sm:w-[240px] sm:shrink-0' : '' }}">@include('pages.services._mini', ['slug' => $serviceSlug])</div>
                            <div>
                                <h4 class="text-[22px] font-medium leading-tight tracking-[-0.02em]">
                                    <a href="{{ route('services.show', $serviceSlug) }}" class="inline-flex min-h-11 items-center after:absolute after:inset-0 after:content-['']">{{ $item['name'] }}</a>
                                </h4>
                                <p class="mt-3 text-[16px] leading-[1.6] text-muted">{{ $item['summary'] }}</p>
                                <p class="mt-4 inline-flex items-center gap-2 text-[15px] font-medium" aria-hidden="true">Explore <span class="text-accent transition-transform group-hover:translate-x-0.5">↗</span></p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-inner.band>

<x-inner.band tone="soft" kicker="Before we begin">
    <x-slot:heading>A conversation.<br>Then a clear scope.</x-slot:heading>
    <x-inner.facts layout="grid" :items="[
        ['01 / Talk it through', 'The goal, what you already have, and what’s getting in the way.'],
        ['02 / Agree the scope', 'You should understand the proposed work and its boundaries.'],
        ['03 / Know the next step', 'A clear next step, understood before the work starts.'],
    ]" />
</x-inner.band>

<x-inner.cta label="Help me find a starting point" body="Start with what you know. We’ll ask the useful questions.">
    <x-slot:heading>Same team.<br><span class="text-[#a7b3a6]">Different starting points.</span></x-slot:heading>
</x-inner.cta>
@endsection
