{{--
    Page header, three genuinely different compositions.
    split:     paper, copy left + optional aside (default slot) right.
    editorial: soft band, oversized title, hairline rule, lede and actions side by side.
    dark:      dark rounded panel on paper (keeps the fixed nav readable), copy left + aside right.
    Slots: title (required), default (aside), actions (optional). Props: variant, kicker, lede.
--}}
@props(['variant' => 'split', 'kicker' => null, 'lede' => null])
@php
    $dark = $variant === 'dark';
    $h1 = 'text-[clamp(2.5rem,8.5vw,5.1rem)] font-medium leading-[1.04] tracking-[-0.045em]';
    $ledeClass = 'text-[17px] leading-[1.6] sm:text-[19px] ' . ($dark ? 'text-white/70' : 'text-muted');
    $shell = 'mx-auto w-full max-w-[1320px] px-5 sm:px-8 lg:px-12';
@endphp
@if($variant === 'editorial')
    <header {{ $attributes->class('overflow-x-clip bg-soft pt-[72px]') }}>
        <div class="{{ $shell }} py-14 sm:py-20 lg:py-28">
            @if($kicker)<x-inner.kicker>{{ $kicker }}</x-inner.kicker>@endif
            <h1 class="{{ $h1 }} mt-6 max-w-[1100px] sm:text-[clamp(3rem,7vw,6.2rem)]">{{ $title }}</h1>
            <div class="mt-10 grid gap-8 border-t border-ink/15 pt-8 lg:grid-cols-[1.2fr_0.8fr] lg:gap-16">
                @if($lede)<p class="{{ $ledeClass }} max-w-[620px]">{{ $lede }}</p>@endif
                @isset($actions)<div class="flex flex-wrap items-center gap-x-8 gap-y-4 lg:justify-end">{{ $actions }}</div>@endisset
            </div>
            @if($slot->isNotEmpty())<div class="mt-12">{{ $slot }}</div>@endif
        </div>
    </header>
@else
    <header {{ $attributes->class('overflow-x-clip bg-paper pt-[72px]') }}>
        <div class="{{ $dark ? 'on-dark mx-3 overflow-hidden rounded-[16px] bg-dark text-white sm:mx-5' : '' }}">
            <div class="{{ $shell }} grid gap-12 py-12 sm:py-16 lg:grid-cols-[1.1fr_0.9fr] lg:items-center lg:gap-16 lg:py-24">
                <div>
                    @if($kicker)<x-inner.kicker :dark="$dark">{{ $kicker }}</x-inner.kicker>@endif
                    <h1 class="{{ $h1 }} mt-6">{{ $title }}</h1>
                    @if($lede)<p class="{{ $ledeClass }} mt-6 max-w-[580px] sm:mt-7">{{ $lede }}</p>@endif
                    @isset($actions)<div class="mt-8 flex flex-wrap items-center gap-x-8 gap-y-4">{{ $actions }}</div>@endisset
                </div>
                @if($slot->isNotEmpty())<div>{{ $slot }}</div>@endif
            </div>
        </div>
    </header>
@endif
