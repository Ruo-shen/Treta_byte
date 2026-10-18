@extends('layouts.app')
@section('content')
<x-inner.header variant="split" kicker="Route not found / Let’s reconnect" lede="That address doesn’t lead to a page here. The link may have changed, or there may be a typo.">
    <x-slot:title>A wrong turn.<br><span class="text-moss">Not a dead end.</span></x-slot:title>
    <x-slot:actions>
        <x-inner.button :href="route('home')">Return to the homepage</x-inner.button>
    </x-slot:actions>
    <div class="flex select-none justify-center gap-2 text-[clamp(6.5rem,30vw,14rem)] font-medium leading-none tracking-[-0.08em] text-[#c2c9be] md:-rotate-3 lg:justify-end" aria-hidden="true">
        <span>4</span><span class="text-[#d5dacf] line-through decoration-[#71856a] decoration-[3px]">0</span><span>4</span>
    </div>
</x-inner.header>

<x-inner.band tone="soft" kicker="Useful connections">
    <ul class="grid gap-4 md:grid-cols-3">
        @foreach([
            [route('services.index'), 'Services', 'Find help with a website or system'],
            [route('blog.index'), 'Blog', 'Read something useful'],
            [route('contact.show'), 'Contact', 'Explain what you were looking for'],
        ] as [$href, $name, $hint])
            <li>
                <a href="{{ $href }}" class="group flex min-h-[132px] flex-col justify-between rounded-[14px] border border-line bg-white p-6 transition-colors hover:border-ink/30">
                    <span class="text-[16px] leading-snug text-muted">{{ $hint }}</span>
                    <span class="mt-6 flex items-center justify-between text-[26px] font-medium tracking-[-0.025em]">{{ $name }} <span class="text-accent transition-transform group-hover:translate-x-0.5" aria-hidden="true">↗</span></span>
                </a>
            </li>
        @endforeach
    </ul>
</x-inner.band>
@endsection
