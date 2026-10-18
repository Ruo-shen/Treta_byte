{{-- Tiny decorative illustration for a service card. Needs $slug. --}}
@switch($slug)
    @case('website-repair')
        <div class="rounded-lg bg-dark p-4 font-mono text-[12px] leading-[1.9] text-white/75" aria-hidden="true">
            <p><span class="text-sage">$</span> reproduce</p>
            <p><span class="text-sage">$</span> trace the cause</p>
            <p><span class="text-sage">$</span> repair + verify</p>
        </div>
        @break
    @case('web-development')
        <div class="rounded-lg border border-line bg-white p-3" aria-hidden="true">
            <div class="flex gap-1"><span class="h-1.5 w-1.5 rounded-full bg-ink/15"></span><span class="h-1.5 w-1.5 rounded-full bg-ink/15"></span><span class="h-1.5 w-1.5 rounded-full bg-ink/15"></span></div>
            <div class="mt-4 h-3 w-2/3 rounded-sm bg-ink/80"></div>
            <div class="mt-2 h-2 w-1/2 rounded-sm bg-ink/15"></div>
            <div class="mt-4 h-6 w-20 rounded-[3px] bg-moss"></div>
        </div>
        @break
    @case('web-applications')
        <div class="flex items-center gap-2 py-3 font-mono text-[12px]" aria-hidden="true">
            <span class="grid h-12 w-12 place-items-center rounded-lg bg-white ring-1 ring-line">01</span>
            <span class="text-accent">→</span>
            <span class="grid h-12 w-12 place-items-center rounded-lg bg-accent text-white">02</span>
            <span class="text-accent">→</span>
            <span class="grid h-12 w-12 place-items-center rounded-lg bg-white ring-1 ring-line">03</span>
        </div>
        @break
    @case('website-maintenance')
        <div class="grid grid-cols-7 gap-1.5 py-1" aria-hidden="true">
            @foreach(range(1, 14) as $day)
                <span class="grid h-6 place-items-center rounded-[4px] text-[12px] leading-none {{ in_array($day, [4, 11]) ? 'bg-moss text-white' : 'bg-ink/[0.07] text-transparent' }}">✓</span>
            @endforeach
        </div>
        @break
@endswitch
