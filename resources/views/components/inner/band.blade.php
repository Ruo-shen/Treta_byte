{{--
    Section band with shared container and vertical rhythm.
    Props: tone (light|soft), kicker. Slots: heading (optional h2), default.
    Extra attributes (id, class) land on the <section>.
--}}
@props(['tone' => 'light', 'kicker' => null])
<section {{ $attributes->class([$tone === 'soft' ? 'bg-soft' : 'bg-paper', 'scroll-mt-16 overflow-x-clip py-12 sm:py-20 lg:py-24']) }}>
    <div class="mx-auto w-full max-w-[1320px] px-5 sm:px-8 lg:px-12">
        @if($kicker || isset($heading))
            <div class="mb-10 max-w-[760px] sm:mb-14">
                @if($kicker)<x-inner.kicker>{{ $kicker }}</x-inner.kicker>@endif
                @isset($heading)<h2 class="mt-5 text-[clamp(1.9rem,5.5vw,3.2rem)] font-medium leading-[1.1] tracking-[-0.035em]">{{ $heading }}</h2>@endisset
            </div>
        @endif
        {{ $slot }}
    </div>
</section>
