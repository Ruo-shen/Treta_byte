@extends('layouts.app')
@section('content')
@php
    $service = isset($project['service']) ? (config('services.offerings')[$project['service']] ?? null) : null;
    $dimensions = function (array $item, string $key = 'image') {
        if (! empty($item[$key.'_width']) && ! empty($item[$key.'_height'])) {
            return [$item[$key.'_width'], $item[$key.'_height']];
        }
        $size = @getimagesize(public_path($item[$key]));

        return $size ? [$size[0], $size[1]] : [1600, 1000];
    };
    $chapters = $project['chapters'] ?? [];
    $facts = $project['facts'] ?? [];
@endphp
<article class="overflow-x-clip bg-paper pt-[72px]">
    <header class="mx-auto w-full max-w-[1320px] px-5 pb-10 pt-6 sm:px-8 sm:pb-14 lg:px-12 lg:pt-12">
        <x-inner.button :href="route('work.index')" variant="link" :arrow="false">← The project archive</x-inner.button>
        <x-inner.kicker class="mt-8">{{ $service['name'] ?? 'Case study' }}</x-inner.kicker>
        <h1 class="mt-5 max-w-[1000px] text-[clamp(2.5rem,7.5vw,4.8rem)] font-medium leading-[1.04] tracking-[-0.045em]">{{ $project['title'] }}</h1>
        <p class="mt-6 max-w-[720px] text-[17px] leading-[1.6] text-muted sm:text-[20px]">{{ $project['summary'] }}</p>
    </header>

    <div class="mx-auto grid w-full max-w-[1320px] gap-10 px-5 pb-16 sm:px-8 lg:grid-cols-[300px_minmax(0,1fr)] lg:gap-16 lg:px-12 lg:pb-24">
        <aside class="lg:sticky lg:top-24 lg:self-start">
            @if($facts)
                <dl class="grid grid-cols-2 gap-x-6 gap-y-5 border-t border-line pt-5 lg:grid-cols-1">
                    @foreach($facts as $label => $value)
                        <div>
                            <dt class="font-mono text-[12px] uppercase tracking-[0.14em] text-muted">{{ $label }}</dt>
                            <dd class="mt-1.5 text-[16px] leading-snug">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            @endif
            @if($chapters)
                <nav aria-label="Case study sections" class="mt-6 border-t border-line pt-5">
                    <p class="hidden font-mono text-[12px] uppercase tracking-[0.14em] text-muted lg:block">Inside the project</p>
                    <div class="no-scrollbar -mx-5 flex gap-2 overflow-x-auto px-5 sm:-mx-8 sm:px-8 lg:mx-0 lg:mt-3 lg:flex-col lg:gap-0 lg:overflow-visible lg:px-0">
                        @foreach($chapters as $chapter)
                            <a href="#{{ $chapter['id'] }}" class="inline-flex min-h-11 shrink-0 items-center rounded-full border border-line bg-white px-4 text-[15px] hover:border-ink/40 lg:rounded-none lg:border-0 lg:border-b lg:bg-transparent lg:px-0">{{ $chapter['title'] }}</a>
                        @endforeach
                    </div>
                </nav>
            @endif
            @if($service)
                <x-inner.button :href="route('services.show', $project['service'])" variant="link" class="mt-4">Explore the related service</x-inner.button>
            @endif
        </aside>

        <div class="min-w-0">
            @if(!empty($project['image']))
                @php [$w, $h] = $dimensions($project) @endphp
                <figure>
                    <img src="{{ asset($project['image']) }}" alt="{{ $project['image_alt'] ?? '' }}" width="{{ $w }}" height="{{ $h }}" class="h-auto w-full rounded-[14px] border border-line bg-soft">
                    @if(!empty($project['image_caption']))
                        <figcaption class="mt-3 text-[15px] text-muted">{{ $project['image_caption'] }}</figcaption>
                    @endif
                </figure>
            @endif

            @foreach($chapters as $chapter)
                <section id="{{ $chapter['id'] }}" class="scroll-mt-28 {{ $loop->first && empty($project['image']) ? '' : 'mt-14 border-t border-line pt-10 sm:mt-16' }}">
                    <p class="font-mono text-[12px] tracking-[0.14em] text-accent">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                    <h2 class="mt-3 text-[clamp(1.8rem,5vw,2.6rem)] font-medium leading-[1.1] tracking-[-0.03em]">{{ $chapter['title'] }}</h2>
                    <div class="mt-5 max-w-[680px] space-y-5 text-[17px] leading-[1.7] text-muted sm:text-[18px]">
                        @foreach($chapter['paragraphs'] as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>
                    @if(!empty($chapter['points']))
                        <ul class="mt-6 max-w-[680px] space-y-3">
                            @foreach($chapter['points'] as $point)
                                <li class="flex gap-4 text-[17px] leading-[1.5]">
                                    <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-[5px] border border-moss/50 text-moss" aria-hidden="true"><svg viewBox="0 0 12 12" class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2.5 6.5l2.2 2.2L9.5 3.5" /></svg></span>{{ $point }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </section>
            @endforeach

            @if(!empty($project['gallery']))
                <ul class="mt-14 grid gap-5 sm:grid-cols-2">
                    @foreach($project['gallery'] as $shot)
                        @php [$gw, $gh] = $dimensions($shot) @endphp
                        <li>
                            <figure>
                                <img src="{{ asset($shot['image']) }}" alt="{{ $shot['alt'] ?? '' }}" width="{{ $gw }}" height="{{ $gh }}" loading="lazy" class="h-auto w-full rounded-[12px] border border-line bg-soft">
                                @if(!empty($shot['caption']))<figcaption class="mt-2 text-[15px] text-muted">{{ $shot['caption'] }}</figcaption>@endif
                            </figure>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    @if(!empty($project['outcomes']))
        <x-inner.band tone="soft" kicker="What changed">
            <x-slot:heading>The outcome,<br>in plain language.</x-slot:heading>
            <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($project['outcomes'] as $outcome)
                    <li class="flex gap-4 rounded-[12px] border border-line bg-white p-5 text-[17px] leading-[1.5]">
                        <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-moss/10 text-moss" aria-hidden="true"><svg viewBox="0 0 12 12" class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2.5 6.5l2.2 2.2L9.5 3.5" /></svg></span>{{ $outcome }}
                    </li>
                @endforeach
            </ul>
        </x-inner.band>
    @endif
</article>

<x-inner.cta kicker="A similar challenge?" label="Tell us about your project" body="Start with what you know. We’ll ask the useful questions.">
    <x-slot:heading>Your situation will be different.<br><span class="text-[#a7b3a6]">Let’s understand it.</span></x-slot:heading>
</x-inner.cta>
@endsection
