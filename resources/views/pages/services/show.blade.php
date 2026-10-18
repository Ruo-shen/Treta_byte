@extends('layouts.app')
@section('content')
@include('pages.services.details.'.$slug)

<x-inner.band id="scope">
    <div class="grid gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:gap-16">
        <div>
            <x-inner.kicker>A clear scope</x-inner.kicker>
            <h2 class="mt-5 text-[clamp(1.9rem,5.5vw,3.2rem)] font-medium leading-[1.1] tracking-[-0.035em]">What the work<br>can include.</h2>
            <p class="mt-5 max-w-[420px] text-[16px] leading-[1.6] text-muted">The right scope depends on your setup. We agree what’s included before we start.</p>
            <x-inner.button :href="route('services.index')" variant="link" :arrow="false" class="mt-4">Explore all services</x-inner.button>
        </div>
        <x-inner.mockup label="scope / {{ $slug }}">
            <ul class="divide-y divide-line">
                @foreach($service['deliverables'] as $item)
                    <li class="flex gap-4 py-5 first:pt-0 last:pb-0">
                        <span class="mt-1 grid h-6 w-6 shrink-0 place-items-center rounded-[5px] border border-moss/50 text-moss" aria-hidden="true">
                            <svg viewBox="0 0 12 12" class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2.5 6.5l2.2 2.2L9.5 3.5" /></svg>
                        </span>
                        <div>
                            <h3 class="text-[19px] font-medium leading-snug tracking-[-0.01em]">{{ $item['name'] }}</h3>
                            <p class="mt-1.5 text-[16px] leading-[1.6] text-muted">{{ $item['description'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </x-inner.mockup>
    </div>
</x-inner.band>

@if(!empty($projects))
    <x-inner.band kicker="Related work">
        @foreach($projects as $projectSlug => $project)
            <a class="flex min-h-14 items-center justify-between gap-6 border-b border-line py-4 text-[22px] tracking-[-0.02em]" href="{{ route('work.show', $projectSlug) }}">{{ $project['title'] }} <span aria-hidden="true">↗</span></a>
        @endforeach
    </x-inner.band>
@endif

<x-inner.cta label="Discuss {{ strtolower($service['name']) }}" :href="route('contact.show', ['topic' => $service['pillar']])" body="Start with what you know. We’ll ask the useful questions." />
@endsection
