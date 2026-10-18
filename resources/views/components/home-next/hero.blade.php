<section id="top" class="relative overflow-hidden bg-paper pt-[72px]">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 opacity-60" style="background-image:linear-gradient(var(--color-line) 1px, transparent 1px), linear-gradient(90deg, var(--color-line) 1px, transparent 1px);background-size:120px 120px;mask-image:radial-gradient(ellipse at 50% 30%, #000 20%, transparent 70%)"></div>
    <div class="relative mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
        {{-- Desktop marginalia: sticky notes and a terminal card around the headline. --}}
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 hidden xl:block">
            <div class="absolute left-[7%] top-[70px] w-[180px] -rotate-6"><x-inner.note :tape="false" tilt="none" class="!p-5 !text-[21px] !leading-[1.15]">Broken website?<br>New feature?<br>Need support?</x-inner.note></div>
            <svg class="absolute left-[12%] top-[218px] h-10 w-8 text-ink/40" viewBox="0 0 30 40" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M22 38C10 30 6 18 9 4M9 4L4 10M9 4l5 5" /></svg>
            <p class="absolute left-[15%] top-[250px] rotate-[-4deg] font-hand text-[20px] leading-none text-ink/65">Real problems.</p>
            <div class="absolute right-[8%] top-[60px] w-[160px] rotate-[5deg]"><x-inner.note :tape="false" tilt="none" class="!p-5 !text-[21px] !leading-[1.35]">
                @foreach(['Fix', 'Build', 'Care'] as $word)
                    <p class="flex items-center gap-2.5"><span class="grid h-4 w-4 place-items-center rounded-[3px] border border-ink/50 text-moss"><x-inner.check class="h-2.5 w-2.5" /></span>{{ $word }}</p>
                @endforeach
            </x-inner.note></div>
            <p class="absolute right-[4%] top-[205px] rotate-[-5deg] text-right font-hand text-[19px] leading-[1.05] text-ink/65">Same goal.<br>Different projects.</p>
            <div class="on-dark absolute right-[10%] top-[285px] w-[250px] -rotate-3 rounded-lg bg-ink p-4 font-mono text-[12px] leading-[1.7] text-white/75 shadow-[0_18px_34px_-20px_rgba(23,25,27,0.6)]">
                <p class="flex items-center gap-2 text-white/90"><span class="h-1.5 w-1.5 rounded-full bg-sage"></span>issue: checkout form failing</p>
                <p><span class="text-sage">›</span> reproduce on staging</p>
                <p><span class="text-sage">›</span> trace error in logs</p>
                <p><span class="text-sage">›</span> fix root cause, add test</p>
                <p class="text-white/90"><span class="text-sage">›</span> deploy &amp; keep watching_</p>
            </div>
        </div>
        <div class="relative mx-auto max-w-[760px] pb-14 pt-14 text-center sm:pb-20 sm:pt-20 lg:pb-24">
            <p class="inline-flex items-center gap-2 rounded-full bg-white px-3.5 py-1.5 font-mono text-[12px] uppercase tracking-[0.18em] text-ink/75 ring-1 ring-line"><span class="h-1.5 w-1.5 rounded-full bg-moss"></span>Digital solutions studio</p>
            <h1 class="mt-6 text-[clamp(2.6rem,6.4vw,5.4rem)] font-semibold leading-[0.98] tracking-[-0.045em] sm:mt-7">Technology should<br>work <span class="text-moss">for you.</span></h1>
            <p class="mx-auto mt-6 max-w-[560px] text-[17px] leading-[1.6] text-muted sm:mt-7 sm:text-[18px]">We fix what's broken, build what's needed, and care for what matters — so your business can move forward without technical headaches.</p>
            <div class="mt-8 flex flex-col items-stretch justify-center gap-3 sm:mt-9 sm:flex-row sm:items-center">
                <x-inner.button href="/contact">Tell us your problem</x-inner.button>
                <a href="#process" class="inline-flex min-h-[52px] items-center justify-center gap-2.5 rounded-[8px] bg-white px-6 text-[15.5px] font-medium ring-1 ring-line transition-colors hover:ring-ink/30">Explore our approach <span aria-hidden="true">→</span></a>
            </div>
            <div aria-hidden="true" class="mt-10 flex items-center justify-center gap-5 xl:hidden">
                <x-inner.note :tape="false" tilt="left" class="!px-4 !py-3 text-left !text-[18px] !leading-[1.15]">Broken website?<br>Need support?</x-inner.note>
                <p class="rotate-[-4deg] text-left font-hand text-[19px] leading-[1.05] text-ink/60">Real problems.<br>Practical fixes.</p>
            </div>
        </div>
    </div>
</section>
