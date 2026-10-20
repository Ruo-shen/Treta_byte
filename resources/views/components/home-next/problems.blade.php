@php
    // [image, title, text, linked service name, service slug, image height attr, object-position]
    $problems = [
        ['4', 'A website that<br class="hidden lg:inline"> keeps breaking', 'Slow pages, failing forms, errors after updates — problems that come back no matter how often they are patched.', 'Website repair', 'website-repair', 530, '50% 50%'],
        ['3', 'Too much<br class="hidden lg:inline"> manual work', 'Spreadsheets, copy-paste and repeated tasks that take your team away from the work that matters.', 'Web applications', 'web-applications', 529, '50% 60%'],
        ['1', 'Tools that<br class="hidden lg:inline"> do not connect', 'Payments, bookings, email and records living in separate places that never quite match.', 'Web applications', 'web-applications', 532, '50% 50%'],
        ['2', 'Nobody responsible<br class="hidden lg:inline"> for upkeep', 'No updates, no backups and no one to call when something goes wrong — often after a developer has moved on.', 'Website maintenance', 'website-maintenance', 533, '50% 50%'],
    ];
@endphp
<section id="problems" class="hx-section scroll-mt-16 overflow-x-clip bg-paper">
    <div class="hx-wrap">
        <div class="hx-reveal relative max-w-[660px]">
            <h2>Common problems,<br>practical <span class="text-moss">fixes.</span></h2>
            <p class="mt-5 max-w-[52ch] text-[16.5px] leading-[1.6] text-muted sm:text-[17px]">Most businesses do not need more technology. They need the technology they already have to work — reliably, and without constant firefighting.</p>
        </div>
        <ol class="mt-8 sm:mt-12 sm:grid sm:grid-cols-2 sm:gap-x-8 sm:gap-y-12 lg:grid-cols-4 lg:gap-x-0 lg:gap-y-0">
            @foreach($problems as $i => [$img, $title, $text, $service, $slug, $h, $pos])
                <li class="hx-reveal hx-prob group relative grid grid-cols-[76px_1fr] items-center gap-x-4 border-t border-line py-5 sm:block sm:border-t-0 sm:py-0 lg:px-8 lg:first:pl-0 lg:last:pr-0 {{ $loop->first ? '' : 'lg:border-l' }}" style="--i:{{ $i }}">
                    <div class="aspect-square overflow-hidden sm:mx-auto sm:aspect-auto sm:h-[130px] sm:max-w-[300px]">
                        <img src="/images/problems/{{ $img }}.webp" width="960" height="{{ $h }}" alt="" loading="lazy" decoding="async" class="hn-fade h-full w-full object-cover transition-transform duration-[600ms] ease-[cubic-bezier(0.23,1,0.32,1)] group-hover:scale-[1.03]" style="object-position:{{ $pos }}">
                    </div>
                    <div class="sm:mt-6">
                        <h3 id="problem-{{ $i }}" class="text-[18px] font-medium leading-[1.2] tracking-[-0.02em] sm:text-[20px]">{!! $title !!}</h3>
                        <p class="mt-2 text-[15px] leading-[1.45] text-muted sm:mt-3 sm:text-[16px] sm:leading-[1.5] lg:max-w-[250px]">{{ $text }}</p>
                        <a href="{{ route('services.show', $slug) }}" aria-describedby="problem-{{ $i }}" class="hx-link mt-1 after:absolute after:inset-0 after:content-[''] sm:mt-2">{{ $service }} <x-inner.icon name="arrow" class="h-4 w-4" /></a>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>
