@php
    $steps = [
        ['Listen', 'We start with a conversation about what is working, what is not, and what success should look like.'],
        ['Diagnose', 'A focused technical review turns symptoms into causes, and causes into a plan you can actually read.'],
        ['Deliver', 'We build in short, visible steps — shipping early, testing properly and keeping you in the loop.'],
        ['Maintain', 'After launch we stay close: monitoring, improving and fixing before small issues become big ones.'],
    ];
@endphp
<section id="process" class="hx-section scroll-mt-16 bg-paper">
    <div class="hx-wrap grid gap-10 lg:grid-cols-[1fr_1.5fr] lg:gap-20">
        <div class="hx-reveal lg:sticky lg:top-28 lg:self-start">
            <h2>Clear steps.<br>No surprises.</h2>
            <p class="mt-5 max-w-[38ch] text-[16.5px] leading-[1.6] text-muted sm:text-[17px]">Every engagement follows the same honest rhythm, whether it's a two-day fix or a two-year partnership.</p>
        </div>
        {{-- data-process: a tiny script marks the step nearest the middle of the viewport; without it the spine is simply complete --}}
        <ol class="hx-process" data-process>
            @foreach($steps as $i => [$name, $text])
                <li class="hx-step hx-reveal grid grid-cols-[2.25rem_1fr] gap-x-3 py-5 sm:grid-cols-[3.5rem_9rem_1fr] sm:gap-x-6 sm:py-7" style="--i:{{ $i }}">
                    <span class="hx-num font-mono text-[12px] tabular-nums">0{{ $loop->iteration }}</span>
                    <h3 class="text-[22px] font-medium leading-tight tracking-[-0.02em] sm:text-[28px]">{{ $name }}</h3>
                    <p class="col-start-2 mt-2 text-[16px] leading-[1.6] text-muted sm:col-start-3 sm:mt-1.5">{{ $text }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>
