{{--
    "How we work together": three ways to engage (structure only). Per-option terms (scope, timeline, pricing model)
    are placeholders until the owner supplies approved content. Props: tone, art (optional [key => trusted SVG/HTML] for keys one-off, project, ongoing; overrides the default sketch from x-inner.engagement-art).
--}}
@props(['tone' => 'soft', 'art' => []])
@php
    $options = [
        ['one-off', 'One-off fix', 'A defined problem, solved and documented.', 'fix'],
        ['project', 'Project', 'A new website, tool or system, built end to end.', 'build'],
        ['ongoing', 'Ongoing care', 'A monthly arrangement for maintenance and improvements.', 'care'],
    ];
@endphp
<x-inner.band :tone="$tone" kicker="How we work together" {{ $attributes }}>
    <x-slot:heading>Three ways we help.</x-slot:heading>
    <ul class="grid gap-4 md:grid-cols-3 md:gap-5">
        @foreach($options as $n => [$key, $name, $text, $topic])
            <li class="hn-card group relative flex flex-col p-5 sm:p-6">
                @if(!empty($art[$key]))
                    <div class="mb-5" aria-hidden="true">{!! $art[$key] !!}</div>
                @else
                    <div class="mb-5 rounded-[10px] bg-soft p-3"><x-inner.engagement-art :name="$key" /></div>
                @endif
                <span class="font-mono text-[12px] tracking-[0.14em] text-accent">0{{ $n + 1 }}</span>
                <h3 class="mt-2 text-[22px] font-medium leading-tight tracking-[-0.02em]">{{ $name }}</h3>
                <p class="mt-2 text-[16px] leading-[1.55] text-muted">{{ $text }}</p>
                <x-inner.placeholder class="mt-4" :what="strtolower($name).' terms: scope, timeline, pricing model (owner to supply, approved)'" />
                <a href="{{ route('contact.show', ['topic' => $topic]) }}" class="mt-auto inline-flex min-h-11 items-center gap-2 pt-2 text-[15px] font-medium text-accent after:absolute after:inset-0 after:content-['']">Discuss this<span class="sr-only"> {{ strtolower($name) }}</span> <x-inner.icon name="arrow" class="h-4 w-4" /></a>
            </li>
        @endforeach
    </ul>
</x-inner.band>
