@php
    $arrow = '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5" aria-hidden="true"><path d="M2.5 8h11M9 3.5L13.5 8 9 12.5" /></svg>';
    $box = 'absolute inset-0 overflow-hidden';
    $dark = 'rounded-[18px] bg-gradient-to-br from-[#2c2d30] to-[#1b1c1e] shadow-[0_30px_50px_-20px_rgba(0,0,0,0.9)] ring-1 ring-white/[0.06]';
    $items = [
        ['Better support', 'Someone who answers, understands your setup and stays involved.', '/services/website-maintenance'],
        ['Clearer communication', 'Plain language, honest estimates and no hidden surprises.', '/about'],
        ['Accountable delivery', 'We own the work we do — before, during and after launch.', '/services'],
    ];
@endphp
<section class="on-dark relative overflow-x-clip bg-[#141517] text-white">
    <div class="relative mx-auto grid w-full max-w-[1440px] gap-10 px-5 py-14 sm:px-8 lg:grid-cols-[0.93fr_1.07fr] lg:gap-0 lg:py-[72px] lg:pl-[108px] lg:pr-[64px]">
        <div class="reveal lg:pb-[300px]">
            <x-inner.kicker dark>Why TRETA exists</x-inner.kicker>
            <h2 class="mt-6 text-[clamp(2.2rem,6vw,3.15rem)] font-medium leading-[1.05] tracking-[-0.04em] lg:ml-4 lg:mt-8">Technology should<br>work for you.<br><span class="text-[#b7c1b9]">Not the other way around.</span></h2>
            <p class="mt-5 max-w-[520px] text-[17px] leading-[1.6] text-white/75 lg:ml-4">We came together as professionals who kept seeing the same thing: businesses let down by unclear communication, unfinished work and nobody taking responsibility.</p>
            <div class="relative mt-7 lg:ml-4">
                <a href="#process" class="inline-flex min-h-[48px] items-center gap-3 rounded-md bg-white px-5 text-[15px] text-ink transition-colors hover:bg-paper">Our approach {!! $arrow !!}</a>
                <p aria-hidden="true" class="absolute left-[370px] top-[18px] hidden rotate-[-12deg] font-hand text-[18px] leading-[1.2] text-white/65 lg:block">Same problems.<br>A better way.</p>
                <svg aria-hidden="true" class="absolute left-[470px] top-[40px] hidden h-16 w-8 text-white/55 lg:block" viewBox="0 0 30 60" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M4 4c16 6 22 22 16 50M20 54l-6-7M20 54l4-8" /></svg>
            </div>
        </div>
        <ul class="lg:-mr-[64px]">
            @foreach($items as [$title, $text, $href])
                <li class="{{ $loop->first ? '' : 'border-t border-white/10 lg:mt-[16px]' }} {{ $loop->last ? 'lg:pt-[16px]' : '' }}">
                    <div class="reveal grid gap-6 py-6 sm:grid-cols-2 sm:items-center sm:py-0 {{ $loop->iteration === 2 ? 'lg:grid-cols-[0.95fr_1.05fr]' : 'lg:grid-cols-[1.02fr_0.98fr] lg:pr-[64px]' }}">
                        <div class="relative hidden aspect-[16/9.4] overflow-hidden sm:block {{ $loop->iteration === 2 ? 'sm:order-2 lg:aspect-[16/10]' : 'rounded-[6px]' }}" aria-hidden="true">
                            @if($loop->iteration === 1)
                                <div class="{{ $box }} bg-[radial-gradient(100%_100%_at_30%_0%,#3a3b3d,#18191b_70%)]">
                                    <div class="absolute left-[16%] top-[14%] h-[105%] w-[84%] rotate-[-9deg] {{ $dark }}">
                                        <span class="absolute left-[6%] top-[22%] h-5 w-5 rounded-full bg-[#8fa4f5]"></span>
                                        <div class="absolute left-[16%] top-[10%] rounded-[12px] bg-[#3a3b3e] px-4 py-3 text-[clamp(12px,1.05vw,14px)] leading-[1.45] text-white/90 ring-1 ring-white/10">We're on it.<br>I'll check this now and<br>keep you updated.</div>
                                        <span class="absolute left-[56%] top-[58%] flex gap-1.5 rounded-[10px] bg-[#3a3b3e] px-4 py-3 ring-1 ring-white/10"><span class="h-1.5 w-1.5 rounded-full bg-white/80"></span><span class="h-1.5 w-1.5 rounded-full bg-white/80"></span><span class="h-1.5 w-1.5 rounded-full bg-white/80"></span></span>
                                    </div>
                                </div>
                            @elseif($loop->iteration === 2)
                                <div class="{{ $box }} bg-[radial-gradient(120%_100%_at_80%_0%,#6a645a,#2a2826_70%)]">
                                    <div class="absolute left-[12%] top-[10%] w-[74%] rotate-[-12deg] rounded-[3px] bg-gradient-to-br from-[#f1ede4] to-[#d9d3c6] px-[12%] py-[10%] font-hand text-[clamp(16px,1.5vw,21px)] leading-[1.55] text-ink/85 shadow-[0_30px_40px_-20px_rgba(0,0,0,0.8)]">
                                        @foreach(['Clear scope', 'Realistic timeline', 'Regular updates', 'No surprises'] as $line)
                                            <p class="flex items-center gap-3"><span class="grid h-[15px] w-[15px] shrink-0 place-items-center border-[1.5px] border-ink/80"><x-inner.check class="h-2.5 w-2.5" /></span>{{ $line }}</p>
                                        @endforeach
                                    </div>
                                    <span class="absolute right-[4%] top-[18%] h-[58%] w-[9px] rotate-[18deg] rounded-full bg-gradient-to-r from-[#111] via-[#3a3a3a] to-[#111]"></span>
                                </div>
                            @else
                                <div class="{{ $box }} bg-[radial-gradient(100%_100%_at_30%_0%,#3a3b3d,#18191b_70%)]">
                                    <div class="absolute left-[16%] top-[14%] h-[105%] w-[84%] rotate-[-9deg] {{ $dark }}">
                                        <ul class="absolute left-[12%] top-[10%] space-y-[0.55em] text-[clamp(12px,1.05vw,14px)] text-white/85">
                                            @foreach(['Plan', 'Build', 'Test', 'Deploy'] as $stage)
                                                <li class="flex items-center gap-3"><span class="h-[11px] w-[11px] rounded-full bg-[#2eb56c]"></span>{{ $stage }}</li>
                                            @endforeach
                                            <li class="flex items-center gap-3"><span class="h-[11px] w-[11px] rounded-full border-2 border-[#5b7ff0]"></span>Ongoing support</li>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="{{ $loop->iteration === 2 ? 'sm:order-1 lg:pl-[40px]' : 'lg:pl-[44px]' }}">
                            <span class="font-mono text-[12px] text-white/70">0{{ $loop->iteration }}</span>
                            <h3 class="mt-2 text-[25px] font-medium tracking-[-0.03em]">{{ $title }}</h3>
                            <p class="mt-2 max-w-[300px] text-[16.5px] leading-[1.55] text-white/70">{{ $text }}</p>
                            <a href="{{ $href }}" class="group mt-3 inline-flex min-h-11 items-center gap-3 border-b border-white/25 text-[15px] text-white/90 hover:text-white">Learn more<span class="sr-only"> about {{ strtolower($title) }}</span> {!! $arrow !!}</a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>
