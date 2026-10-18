@extends('layouts.app')
@section('content')
<div class="overflow-x-clip bg-paper pt-[72px]">
    <div class="mx-auto grid w-full max-w-[1320px] gap-12 px-5 pb-16 pt-10 sm:px-8 sm:pt-14 sm:pb-20 lg:grid-cols-[0.95fr_1.05fr] lg:items-start lg:gap-20 lg:px-12 lg:pt-24 lg:pb-28">
        <div class="min-w-0">
            <x-inner.kicker>Contact / Start with the problem</x-inner.kicker>
            <h1 class="mt-6 text-[clamp(2.5rem,8.5vw,5.1rem)] font-medium leading-[1.04] tracking-[-0.045em]">Tell us where<br>it gets <span class="text-moss">stuck.</span></h1>
            <p class="mt-6 max-w-[540px] text-[17px] leading-[1.6] text-muted sm:mt-7 sm:text-[19px]">A website that keeps breaking. A new idea. Too much work in too many places. A few details are enough to start.</p>

            <div class="mt-10 hidden lg:block">
                @include('pages.contact._next')
            </div>
        </div>

        <div class="min-w-0">
            @if(session('inquiry_sent'))
                <div role="status" class="relative rounded-[14px] border border-line bg-white p-6 shadow-[0_28px_60px_-44px_rgba(23,25,27,0.45)] sm:p-9">
                    <span class="grid h-14 w-14 place-items-center rounded-full bg-moss text-white" aria-hidden="true">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.5l4.5 4.5L19 7.5" /></svg>
                    </span>
                    <x-inner.kicker class="mt-6">Inquiry received</x-inner.kicker>
                    <h2 class="mt-4 text-[clamp(2rem,6vw,2.8rem)] font-medium leading-[1.06] tracking-[-0.035em]">Your note<br>made it through.</h2>
                    <p class="mt-4 text-[17px] leading-[1.6] text-muted">Thanks for explaining what’s going on. We’ll use the email you provided to follow up.</p>
                    <dl class="mt-7 border-y border-dashed border-ink/25 py-5 font-mono text-[13px] uppercase tracking-[0.1em]">
                        <div class="flex justify-between gap-6"><dt class="text-muted">Status</dt><dd>Received</dd></div>
                        <div class="mt-3 flex justify-between gap-6"><dt class="text-muted">Next step</dt><dd class="text-right">A conversation about the work</dd></div>
                    </dl>
                    <div class="mt-6 flex flex-wrap gap-x-8 gap-y-1">
                        <x-inner.button :href="route('services.index')" variant="link">Explore what we do</x-inner.button>
                        <x-inner.button :href="route('contact.show')" variant="link" :arrow="false">Send another inquiry</x-inner.button>
                    </div>
                </div>
            @else
                <div class="rounded-[14px] border border-line bg-white p-5 shadow-[0_28px_60px_-44px_rgba(23,25,27,0.45)] sm:p-9">
                    <div class="mb-6 flex items-center justify-between gap-4 border-b border-line pb-5">
                        <p class="font-mono text-[12px] uppercase tracking-[0.16em] text-muted">A note to TRETA Lab</p>
                        <span class="text-muted" aria-hidden="true">↗</span>
                    </div>
                    <h2 class="sr-only">Send an inquiry</h2>
                    @include('components.inquiry-form')
                </div>
            @endif

            <div class="mt-10 lg:hidden">
                @include('pages.contact._next')
            </div>
        </div>
    </div>
</div>
@endsection
