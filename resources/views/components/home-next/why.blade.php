@php
    $items = [
        ['Better support', 'Someone who answers, understands your setup and stays involved.'],
        ['Clearer communication', 'Plain language, honest estimates and no hidden surprises.'],
        ['Accountable delivery', 'We own the work we do — before, during and after launch.'],
    ];
@endphp
<section id="why" class="hx-why on-dark relative overflow-hidden text-white">
    <div class="hx-wrap hx-section relative grid gap-12 lg:grid-cols-12 lg:gap-16">
        <div class="hx-reveal lg:col-span-5">
            <p class="hx-kicker">Why TRETA exists</p>
            <h2 class="mt-6">We’re three friends bringing our skills together as one team.</h2>
            <div class="mt-10 lg:mt-12">
                <div class="hx-paper -rotate-[3deg]" aria-label="What to expect">
                    @foreach(['Clear scope', 'Realistic timeline', 'Regular updates', 'No surprises'] as $line)
                        <p><span class="hx-box" aria-hidden="true"><x-inner.check class="h-3 w-3" /></span>{{ $line }}</p>
                    @endforeach
                </div>
                <p aria-hidden="true" class="mt-5 pl-2 font-hand text-[22px] leading-[1.1] text-white/65">Same problems.<br>A better way.</p>
            </div>
        </div>
        <ul class="lg:col-span-7 lg:pt-2">
            @foreach($items as $i => [$title, $text])
                <li class="hx-reveal border-t border-white/[0.14] py-7 first:border-t-0 first:pt-0 sm:py-9 lg:first:pt-2" style="--i:{{ $i }}">
                    <h3 class="text-[22px] font-medium leading-tight tracking-[-0.02em] sm:text-[26px]">{{ $title }}</h3>
                    <p class="mt-3 max-w-[40ch] text-[16.5px] leading-[1.6] text-white/75 sm:text-[17px]">{{ $text }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</section>
