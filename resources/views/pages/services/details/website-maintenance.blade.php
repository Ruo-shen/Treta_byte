<x-inner.header variant="editorial" kicker="Care / Website maintenance" lede="Websites don’t stand still after launch. Updates, small issues and everyday changes need someone to notice — and someone to act.">
    <x-slot:title>A little care.<br><span class="text-moss">A lot less uncertainty.</span></x-slot:title>
    <x-inner.mockup label="care-rhythm / an example month">
        <div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr_1fr] lg:items-center lg:gap-10">
            <div>
                <p class="font-mono text-[12px] uppercase tracking-[0.14em] text-muted">An example care rhythm</p>
                <p class="mt-3 font-hand text-[30px] leading-[1.15] text-moss">Quiet work.<br>Visible responsibility.</p>
            </div>
            <div>
                <div class="grid grid-cols-7 gap-1.5 sm:gap-2" aria-hidden="true">
                    @foreach(range(1, 28) as $day)
                        <span class="grid aspect-square place-items-center rounded-[6px] font-mono text-[12px] {{ in_array($day, [3, 9, 10, 17, 23]) ? 'bg-moss text-white' : 'bg-ink/[0.06] text-transparent' }}">✓</span>
                    @endforeach
                </div>
                <p class="mt-4 font-mono text-[12px] text-muted">Illustration only. Actual scope and timing are agreed together.</p>
            </div>
            <ul class="space-y-3 text-[16px]">
                @foreach([['Check', 'Notice changes and risks.'], ['Maintain', 'Update and verify safely.'], ['Improve', 'Make useful small changes.'], ['Report', 'Explain what happened.']] as [$verb, $text])
                    <li><span class="font-mono text-[13px] uppercase tracking-[0.1em] text-accent">{{ $verb }}</span> <span class="text-muted">{{ $text }}</span></li>
                @endforeach
            </ul>
        </div>
    </x-inner.mockup>
</x-inner.header>

<x-inner.band kicker="Clear ownership">
    <div class="grid gap-10 lg:grid-cols-[1fr_1fr] lg:gap-16">
        <div>
            <h2 class="text-[clamp(1.9rem,5.5vw,3.2rem)] font-medium leading-[1.1] tracking-[-0.035em]">“Who looks after that?”<br>should have an answer.</h2>
            <p class="mt-5 max-w-[480px] text-[17px] leading-[1.65] text-muted">A maintenance arrangement starts with understanding the system you have. We agree responsibilities, communication, access and what to do when something needs attention.</p>
        </div>
        <ul class="space-y-3">
            @foreach($service['problems'] as $problem)
                <li class="flex items-start gap-4 rounded-[10px] border border-line bg-white px-5 py-4 text-[17px] leading-[1.45]">
                    <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-moss/10 text-moss" aria-hidden="true"><x-inner.check /></span>{{ $problem }}
                </li>
            @endforeach
        </ul>
    </div>
</x-inner.band>

<x-inner.band tone="soft" kicker="Agree it before you need it">
    <x-slot:heading>A care plan should be clear<br class="hidden sm:inline"> about its boundaries.</x-slot:heading>
    <x-inner.facts layout="grid" :items="[
        ['Included work', 'Which systems, updates and routine tasks are covered.'],
        ['Communication', 'How to ask for help and what response arrangements are agreed.'],
        ['Additional work', 'How larger changes are scoped, reviewed and approved.'],
    ]" />
    <x-inner.placeholder class="mt-10" what="care plan options and response times" />
</x-inner.band>
