{{--
    Closing call-to-action band (dark panel). With no arguments it reproduces the approved homepage CTA copy.
    Props: kicker, body, label, href (defaults to the contact page). Slot: heading (optional, may contain <br> and spans).
--}}
@props([
    'kicker' => 'Start a conversation',
    'body' => "Tell us what's going on. We'll reply with honest next steps — even if that means pointing you elsewhere.",
    'label' => 'Tell us what you need',
    'href' => null,
])
<section {{ $attributes->class('bg-paper pb-12 pt-6 sm:pt-10') }}>
    <div class="mx-auto w-full max-w-[1260px] px-5 sm:px-8">
        <div class="on-dark relative overflow-hidden rounded-[16px] bg-dark px-6 py-12 text-white sm:px-14 sm:py-16 lg:px-20">
            <svg aria-hidden="true" class="pointer-events-none absolute bottom-0 right-0 hidden h-[86%] w-[360px] md:block" viewBox="0 0 360 340" fill="none" preserveAspectRatio="xMaxYMax meet">
                <path d="M10 340 A170 170 0 0 1 340 160" stroke="#9a9b9d" stroke-width="1" />
                <path d="M145 340 V30 H250 V168 H360" stroke="#9a9b9d" stroke-width="1" />
                <rect x="250" y="0" width="30" height="30" fill="#315ceb" />
            </svg>
            <div class="relative max-w-[640px]">
                <x-inner.kicker dark>{{ $kicker }}</x-inner.kicker>
                <h2 class="mt-6 text-[clamp(2.1rem,6vw,3.05rem)] font-medium leading-[1.12] tracking-[-0.035em]">
                    @isset($heading){{ $heading }}@else Have something that needs<br><span class="text-[#a7b3a6]">fixing or building?</span>@endisset
                </h2>
                <p class="mt-6 max-w-[480px] text-[16.5px] leading-[1.55] text-white/70">{{ $body }}</p>
                <div class="mt-8 flex flex-wrap items-center gap-x-9 gap-y-5">
                    <x-inner.button :href="$href ?? route('contact.show')" variant="accent">{{ $label }}</x-inner.button>
                </div>
            </div>
        </div>
    </div>
</section>
