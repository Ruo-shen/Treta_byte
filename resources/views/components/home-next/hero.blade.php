@php
    $notes = [
        ['Broken website?', 'Website repair', 'website-repair'],
        ['New feature?', 'Web development', 'web-development'],
        ['Need support?', 'Website maintenance', 'website-maintenance'],
    ];
@endphp
<section id="top" class="relative overflow-hidden bg-paper pt-[72px]">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 opacity-40" style="background-image:linear-gradient(var(--color-line) 1px, transparent 1px), linear-gradient(90deg, var(--color-line) 1px, transparent 1px);background-size:120px 120px;mask-image:radial-gradient(ellipse at 50% 30%, #000 20%, transparent 70%)"></div>
    <div class="relative mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div class="relative mx-auto max-w-[760px] pb-14 pt-12 text-center sm:pb-20 sm:pt-20">
            <p class="hx-load hx-pill" style="--i:0">Based in Nepal <span aria-hidden="true">·</span> Working worldwide</p>
            <h1 class="hx-load mt-6 sm:mt-7" style="--i:1">Technology should<br>work <span class="text-moss">for you.</span></h1>
            <p class="hx-load mx-auto mt-6 max-w-[540px] text-[17px] leading-[1.6] text-muted sm:mt-7 sm:text-[18px]" style="--i:2">We fix what's broken, build what's needed, and care for what matters — so your business can move forward without technical headaches.</p>
            <div class="hx-load mt-8 flex flex-col items-stretch justify-center gap-3 sm:mt-9 sm:flex-row sm:items-center" style="--i:3">
                <a href="{{ route('contact.show') }}" class="hx-btn hx-btn--ink">Tell us your problem <x-inner.icon name="arrow" class="h-4 w-4" /></a>
                <a href="#process" class="hx-btn hx-btn--line">Explore our approach</a>
            </div>
            {{-- below 1280px: the same three links as one compact ruled list --}}
            <ul class="hx-load mx-auto mt-10 max-w-[560px] border-t border-ink/15 text-left xl:hidden" style="--i:4" aria-label="Where to start">
                @foreach($notes as [$label, $service, $slug])
                    <li class="border-b border-ink/15">
                        <a href="{{ route('services.show', $slug) }}" class="hx-row group flex min-h-14 items-center justify-between gap-4 py-2.5">
                            <span class="flex flex-col sm:flex-row sm:items-baseline sm:gap-4">
                                <span class="font-hand text-[24px] leading-[1.1] text-ink/85">{{ $label }}</span>
                                <span class="font-mono text-[12px] leading-[1.4] text-moss">{{ $service }}</span>
                            </span>
                            <x-inner.icon name="arrow" class="h-4 w-4 text-ink/60 transition-transform duration-200 group-hover:translate-x-0.5" />
                        </a>
                    </li>
                @endforeach
            </ul>
            <x-inner.placeholder class="mt-8 text-left" what="hero art slot (illustration or product shot from Claude Design)" />
        </div>
        {{-- >= 1280px: the three desk notes around the headline are real links to the services --}}
        <div class="pointer-events-none absolute inset-0 hidden xl:block">
            <a href="{{ route('services.show', $notes[0][2]) }}" class="hx-note hx-lift pointer-events-auto absolute block left-[6%] top-[84px] w-[190px] -rotate-[5deg]">{{ $notes[0][0] }} <small>{{ $notes[0][1] }} <span aria-hidden="true">→</span></small></a>
            <a href="{{ route('services.show', $notes[1][2]) }}" class="hx-note hx-lift pointer-events-auto absolute block right-[7%] top-[70px] w-[190px] rotate-[4deg]">{{ $notes[1][0] }} <small>{{ $notes[1][1] }} <span aria-hidden="true">→</span></small></a>
            <a href="{{ route('services.show', $notes[2][2]) }}" class="hx-note hx-lift pointer-events-auto absolute block left-[11%] top-[262px] w-[200px] -rotate-[2deg]">{{ $notes[2][0] }} <small>{{ $notes[2][1] }} <span aria-hidden="true">→</span></small></a>
            <div aria-hidden="true" class="on-dark absolute right-[5%] hidden min-[1360px]:block top-[290px] w-[270px] -rotate-3 rounded-[14px] bg-ink p-4 font-mono text-[12px] leading-[1.7] text-white/75 shadow-[0_18px_34px_-20px_rgba(23,25,27,0.6)]">
                <p class="flex items-center gap-2 text-white/90"><span class="h-1.5 w-1.5 rounded-full bg-sage"></span>issue: checkout form failing</p>
                <p><span class="text-sage">›</span> reproduce on staging</p>
                <p><span class="text-sage">›</span> trace error in logs</p>
                <p><span class="text-sage">›</span> fix root cause, add test</p>
                <p class="text-white/90"><span class="text-sage">›</span> deploy &amp; keep watching<span class="hx-caret">_</span></p>
            </div>
        </div>
    </div>
</section>
