@php
    // [position + breakpoint, size, tilt, float delay, image, scroll drift from, scroll drift to]
    // Different drift distances give the tiles depth: bigger and nearer tiles travel less than small, far ones.
    $tiles = [
        ['left-[4%] top-[10%] lg:block', 104, '-6deg', '0s', 'sky-cloud', 60, -120],
        ['left-[5%] bottom-[8%] lg:block', 124, '-4deg', '-4s', 'desk-laptop', 120, -80],
        ['right-[5%] top-[8%] lg:block', 100, '6deg', '-1s', 'glass-tower', 80, -140],
        ['right-[4%] bottom-[10%] lg:block', 124, '4deg', '-5s', 'desk-marble', 140, -60],
        ['left-[12%] top-[30%] lg:block', 48, '8deg', '-2s', 'sky-rays', 200, -160],
        ['left-[3%] top-[48%] lg:block', 56, '-8deg', '-3s', 'sky-cirrus', 150, -200],
        ['right-[11%] top-[28%] lg:block', 52, '-7deg', '-6s', 'glass-diagonal', 180, -150],
        ['right-[3%] top-[50%] lg:block', 60, '5deg', '-1.5s', 'sky-cumulus', 100, -220],
        ['left-[11%] bottom-[30%] lg:block', 44, '6deg', '-4.5s', 'desk-flatlay', 220, -120],
        ['right-[12%] bottom-[28%] lg:block', 48, '-6deg', '-2.5s', 'glass-blue', 90, -180],
        ['left-[12%] top-[50%] xl:block', 80, '5deg', '-2s', 'glass-blue', 110, -110],
        ['right-[12%] top-[48%] xl:block', 80, '-5deg', '-3s', 'sky-rays', 130, -100],
        ['left-[16%] top-[14%] xl:block', 56, '-5deg', '-5.5s', 'desk-marble', 170, -140],
        ['right-[16%] bottom-[16%] xl:block', 56, '7deg', '-0.5s', 'sky-cloud', 160, -130],
    ];
@endphp
<section id="contact" class="relative scroll-mt-16 overflow-clip bg-cloud py-24 sm:py-32">
    @foreach ($tiles as [$pos, $size, $tilt, $delay, $img, $from, $to])
        <img src="{{ asset('images/hero/'.$img.'.webp') }}" alt="" width="{{ $size }}" height="{{ $size }}" loading="lazy" decoding="async" aria-hidden="true"
             class="cta-tile pointer-events-none absolute hidden object-cover ring-1 ring-white/70 {{ $pos }}"
             style="width: {{ $size }}px; height: {{ $size }}px; border-radius: {{ round($size * 0.2) }}px; --tilt: {{ $tilt }}; --d: {{ $delay }}; --from: {{ $from }}px; --to: {{ $to }}px">
    @endforeach
    <div class="reveal is-in relative mx-auto flex w-full max-w-[800px] flex-col items-center px-6 text-center sm:px-8">
        <span class="flex h-20 w-20 items-center justify-center rounded-[22px] bg-white/60 shadow-[0_24px_48px_-24px_rgba(9,101,156,0.4),inset_0_1px_0_rgba(255,255,255,0.9)] ring-1 ring-white/80 backdrop-blur-xl">
            <img src="{{ asset('images/brand/treta-mark-96.png') }}" alt="" width="40" height="40" class="h-10 w-10">
        </span>
        <h2 class="mt-8 font-display text-[clamp(2.4rem,4.4vw,3.6rem)] font-normal leading-[1.1] tracking-[-0.02em]">Have something that needs<br><span class="text-ink/55">fixing or building?</span></h2>
        <p class="mt-6 max-w-[48ch] text-[16px] leading-[1.5] text-muted">Tell us what's going on. We'll reply with honest next steps, even if that means pointing you elsewhere.</p>
        <a href="/contact" class="mt-8 inline-flex min-h-[52px] items-center gap-2 rounded-full bg-pop px-8 text-[15.5px] font-medium text-white shadow-[0_12px_24px_-12px_rgba(205,74,66,0.55)] transition-colors duration-200 hover:bg-pop-hover">Tell us what you need <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" class="h-3.5 w-3.5" aria-hidden="true"><path d="M4.5 11.5l7-7M5.5 4.5h6v6" /></svg></a>
    </div>
</section>
