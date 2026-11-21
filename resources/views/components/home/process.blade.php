@php
    $check = '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-2.5 w-2.5" aria-hidden="true"><path d="M3.5 8.5l3 3 6-6.5" /></svg>';
@endphp
<section id="process" class="relative scroll-mt-16 overflow-clip bg-mist py-16 sm:py-24" aria-labelledby="process-title">
    <i aria-hidden="true" class="pointer-events-none absolute -right-40 -top-24 h-[320px] w-[320px] sm:h-[520px] sm:w-[520px] rounded-full bg-sage/45 blur-3xl"></i>
    <i aria-hidden="true" class="pointer-events-none absolute -bottom-40 -left-32 h-[440px] w-[440px] rounded-full bg-accent/15 blur-3xl"></i>

    <div class="relative mx-auto grid w-full max-w-[1440px] gap-12 px-6 sm:px-8 lg:grid-cols-[minmax(0,0.78fr)_minmax(0,1.22fr)] lg:gap-16 lg:px-12">
        <div class="reveal lg:sticky lg:top-28 lg:self-start">
            <p class="flex items-center gap-4 text-[13px] font-medium text-ink/80">
                <span class="h-2 w-2 bg-accent"></span>Process
            </p>
            <h2 id="process-title" class="mt-6 font-display text-[clamp(2.4rem,4.4vw,3.6rem)] font-normal leading-[1.1] tracking-[-0.02em]">
                Clear steps. <span class="text-ink/55">No surprises.</span>
            </h2>
            <p class="mt-6 max-w-[44ch] text-[16px] leading-[1.6] text-ink/75">Every engagement follows the same honest rhythm, whether it's a quick fix or a long-term partnership.</p>
        </div>

        <ol class="prc-flow" aria-label="How an engagement works">
            {{-- 1. Listen --}}
            <li class="prc-step">
                <span class="prc-dot" aria-hidden="true"><i></i></span>
                <i class="prc-seg" aria-hidden="true"><i></i></i>
                <div class="prc-card grid gap-2 rounded-[28px] bg-white p-2 shadow-[0_24px_48px_-28px_rgba(9,101,156,0.35)] ring-1 ring-line/70 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                    <div class="flex flex-col p-6 sm:p-8">
                        <span class="prc-num" aria-hidden="true">01</span>
                        <h3 class="mt-6 font-display text-[clamp(1.75rem,2.4vw,2.25rem)] font-normal leading-[1.1] tracking-[-0.02em]">Listen</h3>
                        <p class="mt-4 max-w-[38ch] text-[16px] leading-[1.5] text-muted">We start with a conversation about what is working, what is not, and what success should look like.</p>
                    </div>
                    <div class="prc-vis" aria-hidden="true">
                        <i class="absolute -left-10 -top-12 h-52 w-52 rounded-full bg-accent/35 blur-3xl"></i>
                        <i class="absolute -bottom-14 right-0 h-56 w-56 rounded-full bg-sage/80 blur-3xl"></i>
                        <i class="absolute right-10 top-6 h-24 w-24 rounded-full bg-pop/25 blur-2xl"></i>
                        <div class="relative grid w-full max-w-[300px] gap-3">
                            <p class="prc-bub self-start rounded-[18px] rounded-bl-md bg-white/70 px-4 py-3 text-[13px] leading-[1.4] shadow-[0_12px_24px_-16px_rgba(9,101,156,0.5)] ring-1 ring-white/70 backdrop-blur-xl">What is working, and what is not?</p>
                            <p class="prc-bub self-start rounded-[18px] rounded-bl-md bg-white/70 px-4 py-3 text-[13px] leading-[1.4] shadow-[0_12px_24px_-16px_rgba(9,101,156,0.5)] ring-1 ring-white/70 backdrop-blur-xl">What should success look like?</p>
                            <p class="prc-typing justify-self-end rounded-[18px] rounded-br-md bg-accent px-4 py-3.5 shadow-[0_12px_24px_-12px_rgba(9,101,156,0.6)]">
                                <i style="--d:0ms"></i><i style="--d:160ms"></i><i style="--d:320ms"></i>
                            </p>
                        </div>
                    </div>
                </div>
            </li>

            {{-- 2. Diagnose --}}
            <li class="prc-step">
                <span class="prc-dot" aria-hidden="true"><i></i></span>
                <i class="prc-seg" aria-hidden="true"><i></i></i>
                <div class="prc-card grid gap-2 rounded-[28px] bg-white p-2 shadow-[0_24px_48px_-28px_rgba(9,101,156,0.35)] ring-1 ring-line/70 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                    <div class="flex flex-col p-6 sm:p-8">
                        <span class="prc-num" aria-hidden="true">02</span>
                        <h3 class="mt-6 font-display text-[clamp(1.75rem,2.4vw,2.25rem)] font-normal leading-[1.1] tracking-[-0.02em]">Diagnose</h3>
                        <p class="mt-4 max-w-[38ch] text-[16px] leading-[1.5] text-muted">A focused technical review turns symptoms into causes, and causes into a plan you can actually read.</p>
                    </div>
                    <div class="prc-vis" aria-hidden="true">
                        <i class="absolute -right-10 -top-12 h-52 w-52 rounded-full bg-sage/80 blur-3xl"></i>
                        <i class="absolute -bottom-14 left-0 h-56 w-56 rounded-full bg-accent/35 blur-3xl"></i>
                        <i class="absolute bottom-8 right-12 h-24 w-24 rounded-full bg-pop/25 blur-2xl"></i>
                        <div class="relative w-full max-w-[300px] rounded-[18px] bg-white/55 p-3 shadow-[0_24px_48px_-24px_rgba(9,101,156,0.35),inset_0_1px_0_rgba(255,255,255,0.8)] ring-1 ring-white/70 backdrop-blur-2xl">
                            <ul class="grid gap-1">
                                <li class="flex items-center gap-3 rounded-[12px] px-3 py-2.5 text-[13px]">
                                    <span class="grid h-[18px] w-[18px] shrink-0 place-items-center rounded-full bg-accent text-white">{!! $check !!}</span>Symptoms listed
                                </li>
                                <li class="flex items-center gap-3 rounded-[12px] px-3 py-2.5 text-[13px]">
                                    <span class="grid h-[18px] w-[18px] shrink-0 place-items-center rounded-full bg-accent text-white">{!! $check !!}</span>Causes traced
                                </li>
                                <li class="flex items-center gap-3 rounded-[12px] bg-white/70 px-3 py-2.5 text-[13px] ring-1 ring-white/80">
                                    <span class="prc-pulse h-[18px] w-[18px] shrink-0 rounded-full border-2 border-accent"></span>Plan in plain English
                                </li>
                            </ul>
                            <span class="prc-lens"></span>
                        </div>
                    </div>
                </div>
            </li>

            {{-- 3. Deliver --}}
            <li class="prc-step">
                <span class="prc-dot" aria-hidden="true"><i></i></span>
                <i class="prc-seg" aria-hidden="true"><i></i></i>
                <div class="prc-card grid gap-2 rounded-[28px] bg-white p-2 shadow-[0_24px_48px_-28px_rgba(9,101,156,0.35)] ring-1 ring-line/70 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                    <div class="flex flex-col p-6 sm:p-8">
                        <span class="prc-num" aria-hidden="true">03</span>
                        <h3 class="mt-6 font-display text-[clamp(1.75rem,2.4vw,2.25rem)] font-normal leading-[1.1] tracking-[-0.02em]">Deliver</h3>
                        <p class="mt-4 max-w-[38ch] text-[16px] leading-[1.5] text-muted">We build in short, visible steps, shipping early, testing properly and keeping you in the loop.</p>
                    </div>
                    <div class="prc-vis" aria-hidden="true">
                        <i class="absolute -left-10 -top-12 h-52 w-52 rounded-full bg-sage/80 blur-3xl"></i>
                        <i class="absolute -bottom-14 right-0 h-56 w-56 rounded-full bg-accent/35 blur-3xl"></i>
                        <i class="absolute left-12 bottom-8 h-24 w-24 rounded-full bg-pop/25 blur-2xl"></i>
                        <div class="relative w-full max-w-[300px] rounded-[18px] bg-white/55 p-4 shadow-[0_24px_48px_-24px_rgba(9,101,156,0.35),inset_0_1px_0_rgba(255,255,255,0.8)] ring-1 ring-white/70 backdrop-blur-2xl">
                            <ol class="prc-ship grid gap-4">
                                <li class="flex items-center gap-3 text-[13px]">
                                    <span class="grid h-[18px] w-[18px] shrink-0 place-items-center rounded-full bg-accent text-white">{!! $check !!}</span>
                                    <span class="flex-1">Small step shipped</span>
                                    <span class="rounded-md bg-[#e4f3fc] px-2 py-[3px] text-[11px] text-accent-hover">Live</span>
                                </li>
                                <li class="flex items-center gap-3 text-[13px]">
                                    <span class="grid h-[18px] w-[18px] shrink-0 place-items-center rounded-full bg-accent text-white">{!! $check !!}</span>
                                    <span class="flex-1">Tested properly</span>
                                    <span class="rounded-md bg-[#e4f3fc] px-2 py-[3px] text-[11px] text-accent-hover">Passed</span>
                                </li>
                                <li class="flex items-center gap-3 text-[13px]">
                                    <span class="prc-pulse h-[18px] w-[18px] shrink-0 rounded-full border-2 border-accent"></span>
                                    <span class="flex-1">Next step</span>
                                    <span class="rounded-md bg-white px-2 py-[3px] text-[11px] text-muted ring-1 ring-ink/10">In progress</span>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </li>

            {{-- 4. Maintain --}}
            <li class="prc-step">
                <span class="prc-dot" aria-hidden="true"><i></i></span>
                <div class="prc-card grid gap-2 rounded-[28px] bg-white p-2 shadow-[0_24px_48px_-28px_rgba(9,101,156,0.35)] ring-1 ring-line/70 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                    <div class="flex flex-col p-6 sm:p-8">
                        <span class="prc-num" aria-hidden="true">04</span>
                        <h3 class="mt-6 font-display text-[clamp(1.75rem,2.4vw,2.25rem)] font-normal leading-[1.1] tracking-[-0.02em]">Maintain</h3>
                        <p class="mt-4 max-w-[38ch] text-[16px] leading-[1.5] text-muted">After launch we stay close: monitoring, improving and fixing before small issues become big ones.</p>
                    </div>
                    <div class="prc-vis" aria-hidden="true">
                        <i class="absolute -right-10 -top-12 h-52 w-52 rounded-full bg-accent/35 blur-3xl"></i>
                        <i class="absolute -bottom-14 left-0 h-56 w-56 rounded-full bg-sage/80 blur-3xl"></i>
                        <i class="absolute right-8 bottom-10 h-24 w-24 rounded-full bg-pop/25 blur-2xl"></i>
                        <div class="relative w-full max-w-[300px] rounded-[18px] bg-white/55 p-4 shadow-[0_24px_48px_-24px_rgba(9,101,156,0.35),inset_0_1px_0_rgba(255,255,255,0.8)] ring-1 ring-white/70 backdrop-blur-2xl">
                            <svg viewBox="0 0 240 64" class="block h-16 w-full overflow-visible" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path pathLength="100" d="M0 36H52L60 36L68 12L78 56L88 36H136L144 36L152 22L160 46L168 36H240" stroke="#0b78b8" stroke-opacity=".22" stroke-width="2" />
                                <path class="prc-beat" pathLength="100" d="M0 36H52L60 36L68 12L78 56L88 36H136L144 36L152 22L160 46L168 36H240" stroke="#0b78b8" stroke-width="2.5" />
                                <circle cx="68" cy="12" r="4" fill="#cd4a42" />
                            </svg>
                            <ul class="mt-4 flex flex-wrap gap-2">
                                <li class="rounded-full bg-white px-3 py-1.5 text-[12px] ring-1 ring-line">Monitoring</li>
                                <li class="rounded-full bg-white px-3 py-1.5 text-[12px] ring-1 ring-line">Improving</li>
                                <li class="rounded-full bg-white px-3 py-1.5 text-[12px] ring-1 ring-line">Fixing</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
        </ol>
    </div>
</section>
