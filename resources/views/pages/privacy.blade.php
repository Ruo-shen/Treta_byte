@extends('layouts.app')
@php($seo = array_merge($seo ?? [], ['robots' => 'noindex,follow']))
@section('content')
<x-inner.header variant="editorial" kicker="Privacy / Information, plainly" lede="This notice is being prepared alongside the inquiry service. It is prelaunch information, with the remaining decisions stated openly.">
    <x-slot:title>Your information.<br>Handled <span class="text-moss">with care.</span></x-slot:title>
    <x-slot:actions>
        <p class="inline-flex items-center gap-3 rounded-full border border-ink/20 bg-white px-4 py-2.5 text-[15px] leading-snug"><span class="h-2 w-2 shrink-0 rounded-full bg-[#8b7750]" aria-hidden="true"></span>Prelaunch notice · final practices pending confirmation</p>
    </x-slot:actions>
</x-inner.header>

<x-inner.band>
    <div class="grid grid-cols-1 gap-10 lg:grid-cols-[240px_minmax(0,1fr)] lg:gap-20">
        <div class="lg:sticky lg:top-24 lg:self-start">
            <p class="hidden font-mono text-[12px] uppercase tracking-[0.14em] text-muted lg:block">On this page</p>
            <x-inner.chips stack label="Privacy sections" class="lg:mt-3" :items="[
                ['What the form asks for', '#information', false],
                ['Why it is requested', '#purpose', false],
                ['What remains to be confirmed', '#decisions', false],
                ['External services', '#external-services', false],
            ]" />
        </div>

        <div class="max-w-[760px]">
            <x-inner.placeholder class="mb-10" what="final privacy policy: storage and access, retention, how to make a request, email provider (owner to confirm)" />

            <section id="information" class="scroll-mt-28 border-t border-ink/15 pb-12 pt-8">
                <p class="font-mono text-[12px] uppercase tracking-[0.14em] text-accent">01 / Information</p>
                <h2 class="mt-4 text-[clamp(1.6rem,4vw,2rem)] font-medium leading-[1.15] tracking-[-0.025em]">What the form asks for.</h2>
                <div class="mt-5 space-y-4 text-[17px] leading-[1.7] text-muted sm:text-[18px]">
                    <p>The inquiry form asks for your name, email address, an optional company name, a topic and your message. These details help explain the request and provide a way to respond.</p>
                    <p>Please leave out passwords, payment details and sensitive personal information.</p>
                </div>
            </section>

            <section id="purpose" class="scroll-mt-28 border-t border-ink/15 pb-12 pt-8">
                <p class="font-mono text-[12px] uppercase tracking-[0.14em] text-accent">02 / Purpose</p>
                <h2 class="mt-4 text-[clamp(1.6rem,4vw,2rem)] font-medium leading-[1.15] tracking-[-0.025em]">A conversation about your request.</h2>
                <p class="mt-5 text-[17px] leading-[1.7] text-muted sm:text-[18px]">The intended purpose of an inquiry is to understand the work you need and follow up with you. The completed notice will describe the actual storage, email delivery and access practices used by the service.</p>
            </section>

            <section id="decisions" class="scroll-mt-28 border-t border-ink/15 pb-12 pt-8">
                <p class="font-mono text-[12px] uppercase tracking-[0.14em] text-accent">03 / Before launch</p>
                <h2 class="mt-4 text-[clamp(1.6rem,4vw,2rem)] font-medium leading-[1.15] tracking-[-0.025em]">The details still being confirmed.</h2>
                <x-inner.facts class="mt-6" :items="[
                    ['Storage & access', 'Where inquiries are stored and who can access them.'],
                    ['Retention', 'How long information is kept and when it is deleted.'],
                    ['Your requests', 'A verified contact method for questions, corrections or deletion requests.'],
                    ['Email delivery', 'The provider and handling of inquiry notifications.'],
                ]" />
            </section>

            <section id="external-services" class="scroll-mt-28 border-t border-ink/15 pb-12 pt-8">
                <p class="font-mono text-[12px] uppercase tracking-[0.14em] text-accent">04 / External services</p>
                <h2 class="mt-4 text-[clamp(1.6rem,4vw,2rem)] font-medium leading-[1.15] tracking-[-0.025em]">Fonts, analytics and future changes.</h2>
                <div class="mt-5 space-y-4 text-[17px] leading-[1.7] text-muted sm:text-[18px]">
                    <p>This frontend requests fonts from Google Fonts. Your browser contacts that service to load them. @if(blank(config('seo.ga4_measurement_id')))Analytics identifiers and any consent requirements remain pending review; no analytics service is enabled by this frontend.@endif</p>
                    @if(filled(config('seo.ga4_measurement_id')))
                        <x-inner.placeholder what="analytics and consent wording (Google Analytics is configured)" />
                    @endif
                    <p>The notice must be updated to reflect the actual service before launch. This page is excluded from indexing while those details remain unresolved.</p>
                </div>
            </section>

            <x-inner.button :href="route('contact.show')" variant="link">Back to the inquiry page</x-inner.button>
        </div>
    </div>
</x-inner.band>
@endsection
