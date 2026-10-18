<x-inner.header variant="split" kicker="Build / Web development" lede="Explain what you offer. Help the right people find it. Make the next step easy. We build business websites around those jobs.">
    <x-slot:title>A website with<br>a job <span class="text-moss">to do.</span></x-slot:title>
    <x-slot:actions>
        <x-inner.button href="#website-plan" variant="link" :arrow="false">What makes a useful website ↓</x-inner.button>
    </x-slot:actions>
    <div class="relative pb-8">
        <x-inner.mockup tilt="right" label="your-business / a clearer picture" class="bg-[#e6ebe2]" aria-hidden="true">
            <p class="font-mono text-[12px] tracking-[0.15em] text-moss">YOUR BUSINESS</p>
            <p class="mt-8 text-[clamp(1.6rem,6vw,2.1rem)] font-medium leading-[1.1] tracking-[-0.03em]">Here’s what<br>we can help with.</p>
            <p class="mt-3 text-[15px] text-muted">A clear offer. A useful next step.</p>
            <span class="mt-6 inline-block rounded-[4px] bg-moss px-4 py-2.5 text-[14px] text-white">Let’s talk ↗</span>
            <div class="mt-8 grid grid-cols-3 gap-3"><span class="h-12 rounded-[6px] bg-ink/[0.08]"></span><span class="h-12 rounded-[6px] bg-ink/[0.08]"></span><span class="h-12 rounded-[6px] bg-ink/[0.08]"></span></div>
        </x-inner.mockup>
        <x-inner.note tilt="left" class="absolute -bottom-1 right-2 w-[210px] p-4 text-[22px] sm:right-6">Clarity before decoration.</x-inner.note>
        <p class="mt-5 font-mono text-[12px] text-muted">Concept illustration — not a client website</p>
    </div>
</x-inner.header>

<x-inner.band id="website-plan" kicker="Built around people">
    <x-slot:heading>A good website answers<br class="hidden sm:inline"> the right questions.</x-slot:heading>
    <ol class="grid gap-10 md:grid-cols-3 md:gap-8">
        @foreach([
            ['What do you do?', 'Structure and language that make the business understandable, without making visitors work for it.'],
            ['Can I trust you?', 'Real work, honest information and an experience that feels considered on every screen.'],
            ['What happens next?', 'Clear contact paths, useful content and accessible controls that help people take the next step.'],
        ] as $n => [$question, $answer])
            <li class="border-t border-ink/15 pt-5">
                <span class="font-mono text-[56px] font-light leading-none tracking-[-0.04em] text-accent/30" aria-hidden="true">0{{ $n + 1 }}</span>
                <h3 class="mt-6 text-[26px] font-medium leading-tight tracking-[-0.025em]">{{ $question }}</h3>
                <p class="mt-3 text-[16px] leading-[1.6] text-muted">{{ $answer }}</p>
            </li>
        @endforeach
    </ol>
</x-inner.band>

<x-inner.band tone="soft" kicker="From first sketch to handover">
    <x-slot:heading>Build the right thing.<br>Then build it well.</x-slot:heading>
    <ol class="relative grid gap-0 lg:grid-cols-4 lg:gap-8">
        @foreach([
            ['Understand', 'Audience, goals, existing content and what needs to change.'],
            ['Shape', 'Page structure, content priorities and a visual direction.'],
            ['Build & check', 'Responsive pages, accessible interactions and the details that make a site dependable.'],
            ['Hand over', 'A clear launch plan, access and documentation for the people maintaining it.'],
        ] as $n => [$stage, $text])
            <li class="relative border-l border-moss/40 pb-9 pl-8 last:pb-0 lg:border-l-0 lg:border-t lg:pb-0 lg:pl-0 lg:pt-8">
                <span class="absolute -left-[7px] top-1 h-3.5 w-3.5 rounded-full border-2 border-moss bg-soft lg:-top-[8px] lg:left-0" aria-hidden="true"></span>
                <p class="font-mono text-[12px] uppercase tracking-[0.14em] text-moss">Step 0{{ $n + 1 }}</p>
                <h3 class="mt-2 text-[24px] font-medium tracking-[-0.02em]">{{ $stage }}</h3>
                <p class="mt-2 max-w-[300px] text-[16px] leading-[1.6] text-muted">{{ $text }}</p>
            </li>
        @endforeach
    </ol>
    <x-inner.placeholder class="mt-10" what="typical timeline for each stage" />
</x-inner.band>
