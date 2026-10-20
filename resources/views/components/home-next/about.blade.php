@php
    $disciplines = [
        ['Design', 'Turns ideas into simple experiences.'],
        ['Technical direction', 'Understands your setup and goals.'],
        ['Engineering', 'Builds useful, reliable systems.'],
        ['Support', 'Keeps everything running smoothly.'],
    ];
@endphp
<section id="about" class="hx-section scroll-mt-16 overflow-x-clip bg-paper">
    <div class="hx-wrap grid items-start gap-10 lg:grid-cols-12 lg:gap-16">
        <div class="hx-reveal lg:col-span-5">
            <h2>A small studio. <span class="hx-dim">You talk directly to the people doing the work.</span></h2>
            <p class="mt-6 max-w-[40ch] text-[16.5px] leading-[1.6] text-muted sm:text-[17px]">A small team taking responsibility from the first conversation onward.</p>
        </div>
        <div class="hx-reveal lg:col-span-7" style="--i:1">
            <ul class="hx-card hx-team p-6 sm:p-8" aria-label="How our disciplines work together">
                @foreach($disciplines as [$name, $text])
                    <li class="hx-team-item relative pl-9">
                        <p class="text-[19px] font-semibold leading-tight tracking-[-0.015em]">{{ $name }}</p>
                        <p class="mt-1 text-[16px] leading-[1.5] text-muted">{{ $text }}</p>
                    </li>
                @endforeach
            </ul>
            <p class="sr-only">Design, technical direction, engineering and support are disciplines we bring together, not individual staff profiles.</p>
            <x-inner.placeholder class="mt-5" what="team: photos, names and roles (owner to supply, approved)" />
        </div>
    </div>
</section>
