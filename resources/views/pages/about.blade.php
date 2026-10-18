@extends('layouts.app')
@section('content')
<x-inner.header variant="split" kicker="About / A small, senior studio" lede="Technology should work for you. Not the other way around. TRETA Lab exists to make that a practical commitment.">
    <x-slot:title>Three friends.<br>Different skills.<br><span class="text-moss">One responsibility.</span></x-slot:title>
    <x-inner.note tilt="right" class="mx-auto max-w-[400px] p-8 sm:p-10 lg:mx-0 lg:ml-auto">
        <p class="font-mono text-[12px] uppercase leading-relaxed tracking-[0.16em] text-muted">The idea we came together around</p>
        <p class="mt-5 font-sans text-[clamp(1.6rem,6vw,1.9rem)] font-medium leading-[1.2] tracking-[-0.03em] text-ink">Fix what’s broken.<br>Build what’s needed.<br>Care for what matters.</p>
        <p class="mt-5 text-[26px] text-moss">And stay accountable for it.</p>
    </x-inner.note>
</x-inner.header>

<x-inner.band tone="soft" kicker="Why a studio?">
    <x-slot:heading>Good work needs<br>more than <span class="text-moss">good code.</span></x-slot:heading>
    <div class="grid gap-6 text-[17px] leading-[1.7] text-muted sm:text-[19px] lg:grid-cols-2 lg:gap-16">
        <p>It needs someone to understand the problem, ask useful questions, and explain the choices. It needs design and engineering to work together. And it needs care after the first version is finished.</p>
        <p>We’re three friends bringing our skills together as one team. You speak directly with the people doing the work, with a shared responsibility for getting it right.</p>
    </div>
</x-inner.band>

<x-inner.band kicker="The working agreement">
    <x-slot:heading>What we want working together<br class="hidden sm:inline"> to feel like.</x-slot:heading>
    <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach([
            ['Clear.', 'Plain language, useful questions and a scope you can understand.', 'border border-line bg-white'],
            ['Considered.', 'Choices shaped around the business and the people using the system.', 'bg-mist'],
            ['Accountable.', 'Visible progress, honest tradeoffs and responsibility for the work.', 'border border-line bg-white'],
            ['Human.', 'A conversation with the people involved, without the unnecessary layers.', 'on-dark bg-dark text-white'],
        ] as $n => [$value, $text, $tone])
            <li class="flex min-h-[190px] flex-col sm:min-h-[240px] justify-between rounded-[14px] p-6 sm:p-7 {{ $tone }}">
                <span class="font-mono text-[12px] tracking-[0.14em] {{ $n === 3 ? 'text-sage' : 'text-accent' }}">0{{ $n + 1 }}</span>
                <div>
                    <h3 class="text-[30px] font-medium leading-none tracking-[-0.03em]">{{ $value }}</h3>
                    <p class="mt-3 text-[16px] leading-[1.55] {{ $n === 3 ? 'text-white/70' : 'text-muted' }}">{{ $text }}</p>
                </div>
            </li>
        @endforeach
    </ul>
</x-inner.band>

@if(app()->environment('local'))
    <x-inner.band tone="soft" kicker="The team">
        <x-slot:heading>The people doing the work.</x-slot:heading>
        <div class="grid gap-5 sm:grid-cols-3">
            @foreach(range(1, 3) as $member)
                <x-inner.placeholder class="min-h-[220px]" what="team member {{ $member }}: photo, name and role (owner to supply, approved)" />
            @endforeach
        </div>
    </x-inner.band>
@endif

<x-inner.cta label="Let’s talk" body="Tell us what you’re working on.">
    <x-slot:heading>Good collaboration starts<br><span class="text-sage">with a conversation.</span></x-slot:heading>
</x-inner.cta>
@endsection
