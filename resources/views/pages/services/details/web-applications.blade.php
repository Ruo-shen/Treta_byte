<x-inner.header variant="split" kicker="Build / Web applications" lede="When the work lives between spreadsheets, inboxes and disconnected tools, a useful application can bring it together.">
    <x-slot:title>Less copying.<br>More <span class="text-moss">getting things done.</span></x-slot:title>
    <x-slot:actions>
        <x-inner.button href="#map-the-work" variant="link" :arrow="false">How we start ↓</x-inner.button>
    </x-slot:actions>
    <x-inner.sketch label="Concept workflow — shaped around your actual process">
        <ol class="relative space-y-3">
            @foreach([
                ['Request comes in', 'One place to capture the information.'],
                ['The team acts', 'A clear next step, with the right context.'],
                ['Systems stay aligned', 'Less re-entry. Fewer loose ends.'],
            ] as $n => [$step, $text])
                <li>
                    <div class="rounded-[12px] bg-white p-4 ring-1 {{ $n === 1 ? 'shadow-[0_12px_30px_-20px_rgba(49,92,235,0.6)] ring-accent/50' : 'ring-line' }}">
                        <span class="font-mono text-[12px] text-accent">0{{ $n + 1 }}</span>
                        <p class="mt-1 text-[19px] font-medium tracking-[-0.01em]">{{ $step }}</p>
                        <p class="mt-1 text-[15px] leading-[1.5] text-muted">{{ $text }}</p>
                    </div>
                    @if($n < 2)<p class="mt-3 text-center text-[22px] leading-none text-accent" aria-hidden="true">↓</p>@endif
                </li>
            @endforeach
        </ol>
    </x-inner.sketch>
</x-inner.header>

<x-inner.band id="map-the-work" kicker="Before writing code">
    <div class="grid gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:gap-16">
        <div>
            <h2 class="text-[clamp(1.9rem,5.5vw,3.2rem)] font-medium leading-[1.1] tracking-[-0.035em]">Map the work.<br>Find the friction.</h2>
            <p class="mt-5 max-w-[460px] text-[17px] leading-[1.65] text-muted">We start with how your team works today: what comes in, where information moves, who needs to act, and where things get stuck.</p>
            <x-inner.note class="mt-8 max-w-[280px]">The best feature might be one less step.</x-inner.note>
        </div>
        <ul class="grid gap-3 sm:grid-cols-2">
            @foreach(['What gets typed twice?', 'Where does work wait?', 'What do people work around?', 'What needs a human decision?'] as $question)
                <li class="flex min-h-[110px] items-end rounded-[12px] border border-line bg-white p-5 text-[21px] font-medium leading-[1.2] tracking-[-0.02em]">{{ $question }}</li>
            @endforeach
        </ul>
    </div>
</x-inner.band>

<x-inner.band tone="soft" kicker="Build only what helps">
    <x-slot:heading>A focused tool.<br>A useful first version.</x-slot:heading>
    <div class="grid items-stretch gap-4 lg:grid-cols-[1fr_auto_1fr] lg:gap-6">
        <div class="rounded-[14px] border border-line bg-white p-6 sm:p-8">
            <p class="font-mono text-[12px] uppercase tracking-[0.14em] text-muted">Where it starts</p>
            <ul class="mt-5 space-y-3">
                @foreach($service['problems'] as $problem)
                    <li class="flex gap-3 text-[16px] leading-[1.5]"><span class="text-muted" aria-hidden="true">—</span>{{ $problem }}</li>
                @endforeach
            </ul>
        </div>
        <p class="self-center text-center text-[28px] leading-none text-accent max-lg:rotate-90" aria-hidden="true">→</p>
        <div class="rounded-[14px] bg-dark p-6 text-white sm:p-8">
            <p class="font-mono text-[12px] uppercase tracking-[0.14em] text-sage">What we agree</p>
            <p class="mt-5 text-[16px] leading-[1.65] text-white/75">Sometimes the answer is connecting existing tools. Sometimes it’s a small internal application. We agree a focused scope, test it against real tasks, and leave room to learn.</p>
            <p class="mt-4 text-[16px] leading-[1.65] text-white/75">Access controls, validation, error states and handover are part of the conversation — not details to discover at the end.</p>
        </div>
    </div>
    <x-inner.placeholder class="mt-10" what="example of a delivered tool, with the client's permission" />
</x-inner.band>
