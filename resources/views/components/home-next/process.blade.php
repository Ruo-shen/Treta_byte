@php
    $steps = [
        ['Listen', 'We start with a conversation about what is working, what is not, and what success should look like.'],
        ['Diagnose', 'A focused technical review turns symptoms into causes, and causes into a plan you can actually read.'],
        ['Deliver', 'We build in short, visible steps — shipping early, testing properly and keeping you in the loop.'],
        ['Maintain', 'After launch we stay close: monitoring, improving and fixing before small issues become big ones.'],
    ];
@endphp
<section id="process" class="scroll-mt-16 bg-paper py-14 sm:py-24">
    <div class="mx-auto grid w-full max-w-[1320px] gap-8 px-5 sm:px-8 lg:grid-cols-[1fr_1.5fr] lg:gap-20 lg:px-12">
        <div class="reveal lg:sticky lg:top-28 lg:self-start">
            <x-inner.kicker>Process</x-inner.kicker>
            <h2 class="mt-5 text-[clamp(2rem,5.5vw,2.9rem)] font-medium leading-[1.04] tracking-[-0.035em]">Clear steps.<br>No surprises.</h2>
            <p class="mt-5 max-w-[380px] text-[16px] leading-[1.6] text-muted">Every engagement follows the same honest rhythm, whether it's a two-day fix or a two-year partnership.</p>
        </div>
        <ol class="border-t border-line">
            @foreach($steps as [$name, $text])
                <li class="reveal grid grid-cols-[40px_1fr] gap-x-3 gap-y-2 border-b border-line py-6 sm:grid-cols-[80px_1fr_1.3fr] sm:gap-8 sm:py-9">
                    <span class="pt-2 font-mono text-[12px] text-accent">0{{ $loop->iteration }}</span>
                    <h3 class="text-[24px] font-medium tracking-[-0.02em]">{{ $name }}</h3>
                    <p class="col-start-2 text-[16px] leading-[1.55] text-muted sm:col-start-3 sm:text-[15px] sm:leading-[1.6]">{{ $text }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>
