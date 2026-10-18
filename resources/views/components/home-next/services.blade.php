@php
    $audit = [
        ['#e5484d', '!', 'Slow page load speed', 'Home page — 4.2s', '#fdecec', '#d93f43', 'High'],
        ['#e39b4b', '!', 'Broken form submissions', '/contact', '#fdf3e6', '#a86a1c', 'Medium'],
        ['#e39b4b', '!', 'Missing meta descriptions', '12 pages', '#fdf3e6', '#a86a1c', 'Medium'],
        ['#2e9e6a', '✓', 'SSL certificate', 'Valid for 89 days', '#e8f5ee', '#237a52', 'Healthy'],
    ];
    $build = [
        [true, 'Discovery & planning', 'Mar 4 – Mar 8', '#e8f5ee', '#237a52', 'Complete'],
        [true, 'Design & development', 'Mar 11 – Apr 12', '#e8f5ee', '#237a52', 'Complete'],
        ['open', 'Content & integrations', 'Apr 15 – Apr 26', '#eaf0fd', '#315ceb', 'In progress'],
        [false, 'Testing & launch', 'Apr 29 – May 3', '#f0f0ee', '#64625d', 'Upcoming'],
    ];
    $care = [
        ['Backups', 'Daily', 'Last backup 2h ago', 'M4 5c0-1.1 3.6-2 8-2s8 .9 8 2-3.6 2-8 2-8-.9-8-2zm0 0v14c0 1.1 3.6 2 8 2s8-.9 8-2V5M4 12c0 1.1 3.6 2 8 2s8-.9 8-2'],
        ['Updates', 'Up to date', 'v2.4.1', 'M20 11a8 8 0 0 0-14.5-4.5M4 4v3h3M4 13a8 8 0 0 0 14.5 4.5M20 20v-3h-3'],
        ['Support', '3 open', 'Avg. reply 1.2h', 'M4 5h16v11H9l-5 4z'],
    ];
    $pill = 'shrink-0 rounded-md px-2 py-[3px] text-[12px]';
    $card = 'rounded-[14px] bg-white shadow-[0_24px_48px_-28px_rgba(23,25,27,0.28)] ring-1 ring-ink/[0.05]';
    $arrow = '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" aria-hidden="true"><path d="M2.5 8h11M9 3.5L13.5 8 9 12.5" /></svg>';
@endphp
<section id="services" class="scroll-mt-16 overflow-x-clip bg-paper py-14 sm:py-[60px]">
    <div class="mx-auto w-full max-w-[1260px] px-5 sm:px-8">
        <div class="grid gap-10 lg:grid-cols-2 lg:gap-8">
            <div class="reveal">
                <x-inner.kicker>Services</x-inner.kicker>
                <h2 class="mt-6 text-[clamp(2.3rem,6vw,3.6rem)] font-semibold leading-[1.02] tracking-[-0.05em] lg:mt-9">Three disciplines. <span class="text-ink/45">One accountable team.</span></h2>
                <p class="mt-6 max-w-[470px] text-[16.5px] leading-[1.45] text-muted lg:mt-7">Engage us for a single fix, a full build, or ongoing care. Same team, same standards, from quick wins to long-term partnerships.</p>
            </div>
            {{-- 01 Fix --}}
            <div class="reveal relative grid gap-8 sm:grid-cols-[210px_1fr] sm:items-start lg:-mr-10">
                <div class="relative z-10 sm:pt-[42px]">
                    <span class="font-mono text-[12px] text-muted">01</span>
                    <h3 class="mt-3 text-[40px] font-medium leading-none tracking-[-0.04em]">Fix</h3>
                    <p class="mt-4 max-w-[270px] text-[16px] leading-[1.45] text-muted">Diagnose, repair and stabilise what's not working — from bugs and performance issues to failing deployments.</p>
                    <a href="/services/website-repair" class="group mt-3 inline-flex min-h-11 items-center gap-2 text-[15px] font-medium text-accent">Explore Fix {!! $arrow !!}</a>
                </div>
                <div class="relative sm:-ml-4">
                    <div aria-hidden="true" class="hn-tint -left-[6%] -top-[28px] hidden h-[66%] w-[60%] sm:block"></div>
                    <div aria-hidden="true" class="hn-dots absolute -right-6 -top-14 hidden h-14 w-28 sm:block"></div>
                    <div class="{{ $card }} relative p-4 sm:mt-2">
                        <div class="flex items-center justify-between gap-3 px-1 pb-3">
                            <p class="text-[14px] font-medium">Site audit</p>
                            <span class="{{ $pill }}" style="background:#fdecec;color:#d93f43">12 issues</span>
                        </div>
                        <ul class="rounded-[10px] ring-1 ring-ink/[0.07]">
                            @foreach($audit as [$dot, $mark, $title, $sub, $bg, $fg, $label])
                                <li class="flex items-center gap-3 px-3 py-[11px] sm:px-4 {{ $loop->first ? '' : 'border-t border-ink/[0.07]' }}">
                                    <span class="grid h-[20px] w-[20px] shrink-0 place-items-center rounded-full text-[12px] font-bold text-white" style="background:{{ $dot }}">{{ $mark }}</span>
                                    <span class="min-w-0 flex-1"><span class="block text-[14px]">{{ $title }}</span><span class="block text-[12px] text-muted">{{ $sub }}</span></span>
                                    <span class="{{ $pill }}" style="background:{{ $bg }};color:{{ $fg }}">{{ $label }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- 02 Build --}}
        <div class="mt-12 grid gap-10 sm:mt-16 lg:mt-14 lg:grid-cols-[1.25fr_0.75fr] lg:items-center lg:gap-14">
            <div class="reveal relative order-2 hidden sm:block lg:order-1 lg:ml-[60px]">
                <div aria-hidden="true" class="hn-tint hn-tint-blue -top-[26px] left-0 hidden h-[118%] w-[56%] sm:block"></div>
                <div aria-hidden="true" class="hn-dots absolute -left-[60px] top-[96px] hidden h-28 w-14 lg:block"></div>
                <div class="relative sm:ml-[125px]">
                    <div class="{{ $card }} p-4 sm:p-5">
                        <div class="flex items-center gap-4 border-b border-ink/[0.07]">
                            <span class="mb-3 grid h-6 w-6 shrink-0 place-items-center rounded-md bg-ink text-[12px] text-white" aria-hidden="true">▣</span>
                            <p class="mb-3 text-[14px] font-medium">Website build</p>
                            <nav aria-hidden="true" class="ml-4 hidden gap-7 text-[12px] text-muted sm:flex">
                                <span class="border-b-2 border-accent pb-3 font-medium text-ink">Plan</span><span class="pb-3">Design</span><span class="pb-3">Build</span><span class="pb-3">Launch</span>
                            </nav>
                        </div>
                        <ul class="mt-3 rounded-[10px] ring-1 ring-ink/[0.07]">
                            @foreach($build as [$state, $title, $dates, $bg, $fg, $label])
                                <li class="flex items-center gap-3 px-3 py-[10px] sm:gap-4 {{ $loop->first ? '' : 'border-t border-ink/[0.07]' }}">
                                    <span class="grid h-[18px] w-[18px] shrink-0 place-items-center rounded-full {{ $state === true ? 'bg-accent text-white' : ($state === 'open' ? 'border-2 border-accent' : 'border border-ink/25') }}">@if($state === true)<x-inner.check class="h-2.5 w-2.5" />@endif</span>
                                    <span class="min-w-0 flex-1 text-[14px]">{{ $title }}</span>
                                    <span class="hidden w-[130px] text-[12px] text-muted sm:block">{{ $dates }}</span>
                                    <span class="{{ $pill }}" style="background:{{ $bg }};color:{{ $fg }}">{{ $label }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="reveal order-1 lg:order-2 lg:pt-6">
                <span class="font-mono text-[12px] text-muted">02</span>
                <h3 class="mt-3 text-[40px] font-medium leading-none tracking-[-0.04em]">Build</h3>
                <p class="mt-4 max-w-[270px] text-[16px] leading-[1.45] text-muted">End-to-end websites, tools or platforms, built for performance and built to last beyond launch.</p>
                <a href="/services/web-development" class="group mt-3 inline-flex min-h-11 items-center gap-2 text-[15px] font-medium text-accent">Explore Build {!! $arrow !!}</a>
            </div>
        </div>
        {{-- 03 Care --}}
        <div class="mt-12 grid gap-8 sm:mt-16 lg:mt-12 lg:grid-cols-[0.62fr_1.38fr] lg:items-end lg:gap-6">
            <div class="reveal lg:pb-2">
                <span class="font-mono text-[12px] text-muted">03</span>
                <h3 class="mt-3 text-[40px] font-medium leading-none tracking-[-0.04em]">Care</h3>
                <p class="mt-4 max-w-[270px] text-[16px] leading-[1.45] text-muted">Ongoing support, monitoring, updates and improvements so everything keeps running smoothly.</p>
                <a href="/services/website-maintenance" class="group mt-3 inline-flex min-h-11 items-center gap-2 text-[15px] font-medium text-accent">Explore Care {!! $arrow !!}</a>
            </div>
            <div class="reveal relative">
                <div aria-hidden="true" class="hn-tint -top-[22px] left-0 hidden h-[115%] w-[86%] sm:block"></div>
                <div aria-hidden="true" class="hn-dots absolute -right-4 -top-2 hidden h-32 w-20 lg:block"></div>
                <div class="relative sm:ml-[52px]">
                    <div class="{{ $card }} p-4 sm:p-5">
                        <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-1 pb-4">
                            <p class="flex items-center gap-2.5 text-[14px] font-medium"><span class="h-2.5 w-2.5 rounded-full bg-[#2eb56c]"></span>System health</p>
                            <p class="flex items-center gap-1.5 text-[12px] text-[#237a52]"><x-inner.check class="h-3 w-3" />All systems operational</p>
                        </div>
                        <div class="grid grid-cols-2 gap-2.5 sm:grid-cols-4">
                            <div class="rounded-[10px] p-3.5 ring-1 ring-ink/[0.08]">
                                <p class="text-[13px]">Uptime</p>
                                <svg viewBox="0 0 100 10" class="mt-1.5 h-2.5 w-full" aria-hidden="true"><path d="M0 6 Q5 2 10 6 T20 6 T30 6 T40 6 T50 6 T60 6 T70 6 T80 6 T90 6 T100 6" fill="none" stroke="#2eb56c" stroke-width="1.4" /></svg>
                                <p class="mt-3 text-[17px] font-medium tracking-[-0.01em]">99.98%</p>
                                <p class="mt-0.5 text-[12px] text-muted">Last 30 days</p>
                            </div>
                            @foreach($care as [$name, $value, $sub, $path])
                                <div class="rounded-[10px] p-3.5 ring-1 ring-ink/[0.08]">
                                    <p class="flex items-center gap-2 text-[13px]"><svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" aria-hidden="true"><path d="{{ $path }}" /></svg>{{ $name }}</p>
                                    <p class="mt-5 text-[16px] font-medium tracking-[-0.01em]">{{ $value }}</p>
                                    <p class="mt-0.5 text-[12px] text-muted">{{ $sub }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <p class="relative mt-3 text-right font-mono text-[12px] uppercase tracking-[0.14em] text-muted sm:mr-1">Sample interfaces, for illustration</p>
            </div>
        </div>
    </div>
</section>
