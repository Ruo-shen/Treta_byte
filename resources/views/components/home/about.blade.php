@php
    // Disciplines, not people: no staff names, faces or titles. --jx/--jy is the resting offset toward the middle of the cluster;
    // --fx/--fy is where the card starts when the section scrolls into view (scroll-driven browsers only).
    $disciplines = [
        ['Design', 'Turns ideas into simple experiences.', 'glass-diagonal', '-6deg', '1.5deg', '10px', '12px', '-36px', '-26px'],
        ['Technical direction', 'Understands your setup and goals.', 'desk-marble', '5deg', '-1.5deg', '-10px', '12px', '36px', '-18px'],
        ['Engineering', 'Builds useful, reliable systems.', 'glass-tower', '6deg', '-1deg', '10px', '-6px', '-30px', '34px'],
        ['Support', 'Keeps everything running smoothly.', 'sky-cloud', '-5deg', '1.2deg', '-10px', '-6px', '30px', '28px'],
    ];
    $principles = [['Fix', 'what is broken.'], ['Build', 'what is needed.'], ['Care', 'for what matters.']];
@endphp
<section id="about" class="scroll-mt-16 overflow-clip bg-white py-16 sm:py-24" aria-labelledby="about-title">
    <div class="mx-auto w-full max-w-[1440px] px-6 sm:px-8 lg:px-12">
        <div class="grid items-center gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:gap-16">
            <div class="reveal">
                <p class="flex items-center gap-4 text-[15px] font-medium text-accent">
                    <span class="h-2 w-2 bg-pop" aria-hidden="true"></span>About TRETA
                </p>
                <h2 id="about-title" class="mt-8 font-display text-[clamp(2.4rem,4.4vw,3.6rem)] font-normal leading-[1.1] tracking-[-0.02em]">
                    A small, senior studio. <span class="block text-ink/55">You talk directly to the people doing the work.</span>
                </h2>
                <p class="mt-8 max-w-[56ch] text-[17px] leading-[1.6] text-muted">
                    Design, technical direction, engineering and support work as one coordinated team. Nothing gets passed along a chain: the specialists who shape the work are the ones you speak to, from the first conversation onward.
                </p>
                <ul class="mt-10 flex flex-wrap gap-x-8 gap-y-3">
                    @foreach ($principles as [$verb, $rest])
                        <li class="font-display text-[22px] font-normal leading-[1.2] tracking-[-0.01em]">
                            <span class="text-accent">{{ $verb }}</span> <span class="text-ink/65">{{ $rest }}</span>
                        </li>
                    @endforeach
                </ul>
                <a href="/about" class="group mt-10 inline-flex min-h-11 items-center gap-2 text-[15px] font-medium text-accent transition-colors duration-200 hover:text-accent-hover">
                    How we work together
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" aria-hidden="true"><path d="M2.5 8h11M9 3.5L13.5 8 9 12.5" /></svg>
                </a>
            </div>

            <div class="reveal ab-stage relative isolate flex min-h-[520px] flex-col items-center justify-center gap-8 overflow-clip rounded-[28px] bg-sky-field p-6 sm:min-h-[600px] sm:p-10 lg:p-12" role="group" aria-label="Four disciplines working as one team">
                <img src="{{ asset('images/hero/sky-cirrus.webp') }}" alt="" width="1200" height="900" loading="lazy" decoding="async" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-70">
                <span aria-hidden="true" class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_50%_45%,rgba(124,192,239,0.45),rgba(124,192,239,0)_70%)]"></span>
                <img src="{{ asset('images/hero/glass-blue.webp') }}" alt="" width="120" height="120" loading="lazy" decoding="async" class="ab-tile absolute right-6 top-6 -z-10 hidden h-24 w-24 rounded-[22px] object-cover sm:block lg:right-10 lg:top-10 lg:h-28 lg:w-28" style="--tilt:8deg;--from:34px;--to:-34px">
                <img src="{{ asset('images/hero/desk-laptop.webp') }}" alt="" width="120" height="120" loading="lazy" decoding="async" class="ab-tile absolute bottom-6 left-6 -z-10 hidden h-24 w-24 rounded-[22px] object-cover sm:block lg:bottom-10 lg:left-10 lg:h-28 lg:w-28" style="--tilt:-8deg;--from:-30px;--to:30px">

                <ul class="ab-cluster relative mx-auto grid w-full max-w-[560px] gap-3 sm:grid-cols-2 sm:gap-4" role="list">
                    @foreach ($disciplines as [$name, $line, $img, $tileTilt, $tilt, $jx, $jy, $fx, $fy])
                        <li class="ab-card rounded-[22px] bg-white/75 p-5 shadow-[0_24px_48px_-24px_rgba(9,101,156,0.35),inset_0_1px_0_rgba(255,255,255,0.8)] ring-1 ring-white/70 backdrop-blur-xl" style="--tilt:{{ $tilt }};--jx:{{ $jx }};--jy:{{ $jy }};--fx:{{ $fx }};--fy:{{ $fy }}">
                            <img src="{{ asset('images/hero/'.$img.'.webp') }}" alt="" width="56" height="56" loading="lazy" decoding="async" class="h-14 w-14 rounded-[16px] object-cover shadow-[0_12px_24px_-12px_rgba(9,101,156,0.45)]" style="rotate:{{ $tileTilt }}">
                            <h3 class="mt-5 font-display text-[22px] font-normal leading-[1.15] tracking-[-0.01em]">{{ $name }}</h3>
                            <p class="mt-2 text-[15px] leading-[1.45] text-muted">{{ $line }}</p>
                        </li>
                    @endforeach
                </ul>

                <span aria-hidden="true" class="ab-badge relative flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-[15px] font-medium text-ink shadow-[0_18px_36px_-14px_rgba(9,101,156,0.5)] ring-1 ring-line/70">
                    <span class="h-2 w-2 bg-pop"></span>One team
                </span>
            </div>
        </div>
        <p class="sr-only">Design, technical direction, engineering and support are disciplines we bring together, not individual staff profiles.</p>
    </div>
</section>
