@php
    $audit = [
        ['!', 'bg-[#b42318]', 'Slow page load speed', 'Home page', 'High', 'bg-[#fdecec] text-[#b42318]'],
        ['!', 'bg-[#a35f12]', 'Broken form submissions', '/contact', 'Medium', 'bg-[#fdf1df] text-[#8a500d]'],
        ['!', 'bg-[#a35f12]', 'Missing meta descriptions', 'Several pages', 'Medium', 'bg-[#fdf1df] text-[#8a500d]'],
        ['✓', 'bg-moss', 'SSL certificate', 'Valid', 'Healthy', 'bg-[#e6eee8] text-[#3b5a47]'],
    ];
    $build = [
        ['done', 'Discovery & planning', 'Complete', 'bg-[#e6eee8] text-[#3b5a47]'],
        ['done', 'Design & development', 'Complete', 'bg-[#e6eee8] text-[#3b5a47]'],
        ['open', 'Content & integrations', 'In progress', 'bg-[#e8edfc] text-[#2a4fd0]'],
        ['todo', 'Testing & launch', 'Upcoming', 'bg-[#efeeea] text-[#5b5953]'],
    ];
    $care = [
        ['Uptime', 'Monitored'],
        ['Backups', 'Scheduled'],
        ['Updates', 'Tracked'],
        ['Support', 'Open requests'],
    ];
    $pill = 'shrink-0 rounded-[8px] px-2 py-[3px] text-[12px] leading-[1.3] font-medium';
@endphp
<section id="services" class="hx-section scroll-mt-16 overflow-x-clip bg-paper">
    <div class="hx-wrap">
        <div class="hx-reveal max-w-[720px]">
            <h2>Three disciplines. <span class="hx-dim">One accountable team.</span></h2>
            <p class="mt-5 max-w-[52ch] text-[16.5px] leading-[1.6] text-muted sm:text-[17px]">Engage us for a single fix, a full build, or ongoing care. Same team, same standards, from quick wins to long-term partnerships.</p>
        </div>

        <div class="mt-14 space-y-16 sm:space-y-24 lg:mt-20 lg:space-y-32">
            {{-- Fix --}}
            <div class="grid items-center gap-8 lg:grid-cols-12 lg:gap-10">
                <div class="hx-reveal relative z-10 lg:col-span-5">
                    <span class="hx-chip">One-off fix</span>
                    <h3 class="hx-service">Fix</h3>
                    <p class="hx-service-copy">Diagnose, repair and stabilise what's not working — from bugs and performance issues to failing deployments.</p>
                    <ul class="mt-4 flex flex-wrap gap-x-6">
                        <li><a href="{{ route('services.show', 'website-repair') }}" class="hx-link">Website repair <x-inner.icon name="arrow" class="h-4 w-4" /></a></li>
                    </ul>
                </div>
                <div class="hx-reveal relative lg:col-span-7" style="--i:1">
                    <div aria-hidden="true" class="hn-tint absolute -right-3 -top-5 hidden h-[88%] w-[72%] sm:block"></div>
                    <div class="hx-card hx-mock relative sm:ml-6">
                        <div class="flex items-center justify-between gap-3 px-1 pb-3">
                            <p class="text-[14px] font-medium">Site audit</p>
                            <span class="{{ $pill }} bg-[#efeeea] text-[#5b5953]">Review</span>
                        </div>
                        <ul class="rounded-[8px] ring-1 ring-ink/[0.08]">
                            @foreach($audit as [$mark, $dot, $title, $sub, $label, $tone])
                                <li class="flex items-center gap-3 px-3 py-2.5 {{ $loop->first ? '' : 'border-t border-ink/[0.08]' }}">
                                    <span class="grid h-5 w-5 shrink-0 place-items-center rounded-full text-[12px] font-bold leading-none text-white {{ $dot }}" aria-hidden="true">{{ $mark }}</span>
                                    <span class="min-w-0 flex-1"><span class="block text-[14px] leading-[1.3]">{{ $title }}</span><span class="block text-[12px] text-muted">{{ $sub }}</span></span>
                                    <span class="{{ $pill }} {{ $tone }}">{{ $label }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <p class="hx-sample sm:ml-6">Sample interface</p>
                </div>
            </div>

            {{-- Build --}}
            <div class="grid items-center gap-8 lg:grid-cols-12 lg:gap-10">
                <div class="hx-reveal relative z-10 lg:order-2 lg:col-span-5">
                    <span class="hx-chip">Project</span>
                    <h3 class="hx-service">Build</h3>
                    <p class="hx-service-copy">End-to-end websites, tools or platforms, built for performance and built to last beyond launch.</p>
                    <ul class="mt-4 flex flex-wrap gap-x-6">
                        <li><a href="{{ route('services.show', 'web-development') }}" class="hx-link">Web development <x-inner.icon name="arrow" class="h-4 w-4" /></a></li>
                        <li><a href="{{ route('services.show', 'web-applications') }}" class="hx-link">Web applications <x-inner.icon name="arrow" class="h-4 w-4" /></a></li>
                    </ul>
                </div>
                <div class="hx-reveal relative lg:order-1 lg:col-span-7" style="--i:1">
                    <div aria-hidden="true" class="hn-tint absolute -left-3 -top-5 hidden h-[88%] w-[72%] sm:block"></div>
                    <div class="hx-card hx-mock relative sm:ml-6">
                        <div class="flex items-center gap-3 border-b border-ink/[0.08] pb-3">
                            <span class="grid h-6 w-6 shrink-0 place-items-center rounded-[8px] bg-ink text-white" aria-hidden="true"><x-inner.icon name="build" class="h-3.5 w-3.5" /></span>
                            <p class="text-[14px] font-medium">Website build</p>
                            <nav aria-hidden="true" class="ml-auto hidden gap-5 text-[12px] text-muted sm:flex">
                                <span class="font-medium text-ink">Plan</span><span>Design</span><span>Build</span><span>Launch</span>
                            </nav>
                        </div>
                        <ul class="mt-3 rounded-[8px] ring-1 ring-ink/[0.08]">
                            @foreach($build as [$state, $title, $label, $tone])
                                <li class="flex items-center gap-3 px-3 py-2.5 {{ $loop->first ? '' : 'border-t border-ink/[0.08]' }}">
                                    <span class="grid h-5 w-5 shrink-0 place-items-center rounded-full {{ $state === 'done' ? 'bg-accent text-white' : ($state === 'open' ? 'border-2 border-accent' : 'border border-ink/25') }}" aria-hidden="true">@if($state === 'done')<x-inner.check class="h-3 w-3" />@endif</span>
                                    <span class="min-w-0 flex-1 text-[14px]">{{ $title }}</span>
                                    <span class="{{ $pill }} {{ $tone }}">{{ $label }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <p class="hx-sample sm:ml-6">Sample interface</p>
                </div>
            </div>

            {{-- Care --}}
            <div class="grid items-center gap-8 lg:grid-cols-12 lg:gap-10">
                <div class="hx-reveal relative z-10 lg:col-span-5">
                    <span class="hx-chip">Ongoing care</span>
                    <h3 class="hx-service">Care</h3>
                    <p class="hx-service-copy">Ongoing support, monitoring, updates and improvements so everything keeps running smoothly.</p>
                    <ul class="mt-4 flex flex-wrap gap-x-6">
                        <li><a href="{{ route('services.show', 'website-maintenance') }}" class="hx-link">Website maintenance <x-inner.icon name="arrow" class="h-4 w-4" /></a></li>
                    </ul>
                </div>
                <div class="hx-reveal relative lg:col-span-7" style="--i:1">
                    <div aria-hidden="true" class="hn-tint absolute -right-3 -top-5 hidden h-[88%] w-[72%] sm:block"></div>
                    <div class="hx-card hx-mock relative sm:ml-6">
                        <div class="flex items-center justify-between gap-3 pb-3">
                            <p class="flex items-center gap-2.5 text-[14px] font-medium"><span class="hx-ring h-2.5 w-2.5 rounded-full bg-moss" aria-hidden="true"></span>System health</p>
                            <span class="{{ $pill }} bg-[#e6eee8] text-[#3b5a47]">Monitored</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2.5 sm:grid-cols-4">
                            @foreach($care as [$name, $status])
                                <div class="rounded-[8px] p-3 ring-1 ring-ink/[0.08]">
                                    <p class="text-[13px]">{{ $name }}</p>
                                    @if($name === 'Uptime')
                                        <svg viewBox="0 0 100 10" width="100" height="10" class="mt-2 h-2.5 w-full" aria-hidden="true"><path d="M0 6 Q5 2 10 6 T20 6 T30 6 T40 6 T50 6 T60 6 T70 6 T80 6 T90 6 T100 6" fill="none" stroke="var(--color-moss)" stroke-width="1.4" /></svg>
                                    @else
                                        <span class="mt-2 block h-2.5"></span>
                                    @endif
                                    <p class="mt-2 text-[15px] font-medium tracking-[-0.01em]">{{ $status }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <p class="hx-sample sm:ml-6">Sample interface</p>
                </div>
            </div>
        </div>
    </div>
</section>
