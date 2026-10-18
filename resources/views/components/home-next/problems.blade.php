@php
    $problems = [
        ['4', 'A website that<br>keeps breaking', 'Slow pages, failing forms, errors after updates — problems that come back no matter how often they are patched.', '50% 50%', 530],
        ['3', 'Too much<br>manual work', 'Spreadsheets, copy-paste and repeated tasks that take your team away from the work that matters.', '50% 60%', 529],
        ['1', 'Tools that<br>do not connect', 'Payments, bookings, email and records living in separate places that never quite match.', '50% 50%', 532],
        ['2', 'Nobody responsible<br>for upkeep', 'No updates, no backups and no one to call when something goes wrong — often after a developer has moved on.', '50% 50%', 533],
    ];
@endphp
<section id="problems" class="scroll-mt-16 overflow-x-clip bg-paper py-14 sm:py-[72px]">
    <div class="mx-auto w-full max-w-[1260px] px-5 sm:px-8">
        <div class="reveal grid gap-5 lg:grid-cols-[1fr_0.8fr] lg:items-end lg:gap-16 lg:pl-[30px]">
            <div>
                <x-inner.kicker>Problems we solve</x-inner.kicker>
                <h2 class="mt-5 text-[clamp(2.3rem,6vw,3.4rem)] font-semibold leading-[0.98] tracking-[-0.05em] sm:mt-6">Common problems,<br>practical <span class="text-moss">fixes.</span></h2>
            </div>
            <p class="max-w-[460px] text-[16.5px] leading-[1.6] text-muted">Most businesses do not need more technology. They need the technology they already have to work — reliably, and without constant firefighting.</p>
        </div>
        <ol class="mt-10 grid gap-x-8 gap-y-8 sm:mt-12 sm:grid-cols-2 sm:gap-y-12 lg:grid-cols-4 lg:gap-x-0 lg:gap-y-0">
            @foreach($problems as [$img, $title, $text, $pos, $h])
                <li class="reveal grid grid-cols-[132px_1fr] items-center gap-4 border-t border-line pt-6 sm:block sm:border-t-0 sm:pt-0 lg:px-[30px] {{ $loop->first ? '' : 'lg:border-l' }}" style="transition-delay:{{ $loop->index * 80 }}ms">
                    <div class="aspect-[960/530] overflow-hidden sm:mx-auto sm:max-w-[320px]">
                        <img src="/images/problems/{{ $img }}.webp" width="960" height="{{ $h }}" alt="" loading="lazy" decoding="async" class="hn-fade h-full w-full object-cover" style="object-position:{{ $pos }}">
                    </div>
                    <div class="sm:mt-6">
                        <span class="font-mono text-[12px] text-accent">0{{ $loop->iteration }}</span>
                        <h3 class="mt-1.5 text-[19px] font-normal leading-[1.2] tracking-[-0.02em] sm:mt-3 sm:text-[20px]">{!! str_replace('<br>', '<br class="hidden lg:block"> ', $title) !!}</h3>
                        <p class="mt-2 text-[15px] leading-[1.4] text-muted sm:mt-3 sm:text-[16px]">{{ $text }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>
