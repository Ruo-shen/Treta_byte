<x-inner.header variant="dark" kicker="Fix / Website repair" lede="When something stops working, another patch isn’t always the answer. We trace the problem, make a focused repair, and explain what changed.">
    <x-slot:title>Fix the cause.<br><span class="text-sage">Not just the symptom.</span></x-slot:title>
    <x-slot:actions>
        <x-inner.button href="#repair-start" variant="link" :arrow="false">What’s happening? ↓</x-inner.button>
    </x-slot:actions>
    <x-inner.mockup dark tilt="left" label="repair.log — a repair, made understandable">
        <ol class="space-y-5">
            @foreach([
                ['reproduce the problem', 'See what the visitor or team sees.'],
                ['trace the cause', 'Follow the failure, not the guesswork.'],
                ['repair + verify', 'Check the fix and the paths around it.'],
                ['document the change_', 'Leave the next person a clearer picture.'],
            ] as $n => [$command, $note])
                <li class="grid grid-cols-[auto_1fr] gap-x-4">
                    <span class="font-mono text-[13px] text-sage">0{{ $n + 1 }}</span>
                    <div>
                        <code class="font-mono text-[15px] text-white">{{ $command }}</code>
                        <p class="mt-1 text-[15px] leading-[1.5] text-white/65">{{ $note }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
        <p class="mt-6 border-t border-white/10 pt-4 font-mono text-[12px] text-white/60">Illustrative diagnostic process</p>
    </x-inner.mockup>
</x-inner.header>

<x-inner.band id="repair-start" kicker="Recognise any of these?">
    <div class="grid gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:gap-16">
        <div>
            <h2 class="text-[clamp(1.9rem,5.5vw,3.2rem)] font-medium leading-[1.1] tracking-[-0.035em]">Start with<br>the symptoms.</h2>
            <p class="mt-5 max-w-[440px] text-[17px] leading-[1.65] text-muted">An error message helps. So does “the form stopped sending on Tuesday.” You don’t need to diagnose it first.</p>
        </div>
        <ul class="space-y-3">
            @foreach($service['problems'] as $problem)
                <li class="flex items-start gap-4 rounded-[10px] border border-line bg-white px-5 py-4 text-[17px] leading-[1.45]">
                    <span class="mt-0.5 font-mono text-[14px] text-accent" aria-hidden="true">↳</span>{{ $problem }}
                </li>
            @endforeach
        </ul>
    </div>
</x-inner.band>

<x-inner.band tone="soft" kicker="A careful repair">
    <div class="grid gap-10 lg:grid-cols-[1fr_1fr] lg:gap-16">
        <div>
            <h2 class="text-[clamp(1.9rem,5.5vw,3.2rem)] font-medium leading-[1.1] tracking-[-0.035em]">Understand the risk.<br>Protect what works.</h2>
            <p class="mt-5 max-w-[520px] text-[17px] leading-[1.65] text-muted">We review the setup and discuss access, backups and a safe place to test before changing a live system. If a rebuild is more sensible than another repair, we’ll explain that tradeoff.</p>
            <x-inner.button :href="route('services.show', 'website-maintenance')" variant="link" class="mt-4">Need someone to keep it healthy afterwards?</x-inner.button>
        </div>
        <x-inner.mockup class="self-start" label="before-we-change-anything.md">
            <ul class="space-y-4 text-[17px]">
                @foreach(['Access', 'Backups', 'A safe place to test'] as $check)
                    <li class="flex items-center gap-4">
                        <span class="grid h-6 w-6 place-items-center rounded-[5px] border border-moss/50 text-moss" aria-hidden="true"><x-inner.check /></span>{{ $check }}
                    </li>
                @endforeach
            </ul>
        </x-inner.mockup>
    </div>
</x-inner.band>
