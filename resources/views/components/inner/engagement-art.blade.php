{{--
    Default sketch for each engagement option (modest line drawings, no gradients or filters; replace freely).
    Prop: name = one-off | project | ongoing. Decorative (aria-hidden). Strokes use currentColor (ink) with moss and accent accents.
--}}
@props(['name'])
<svg viewBox="0 0 200 96" width="200" height="96" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" {{ $attributes->class('h-auto w-full max-w-[220px] text-ink/70') }} aria-hidden="true">
    @if($name === 'one-off')
        {{-- A broken connection between two blocks, patched and checked. --}}
        <rect x="8" y="30" width="44" height="36" rx="5" />
        <path d="M16 42h20M16 50h28M16 58h14" />
        <rect x="148" y="30" width="44" height="36" rx="5" />
        <path d="M156 42h20M156 50h28M156 58h14" />
        <path d="M52 48h22M126 48h22" />
        <path d="M74 48l6-8M80 56l6-8" class="text-accent" stroke="currentColor" />
        <rect x="84" y="36" width="34" height="24" rx="4" class="text-moss" stroke="currentColor" />
        <path d="M94 48l5 5 9-10" class="text-moss" stroke="currentColor" />
        <path d="M100 14v10M96 18l4-4 4 4" class="text-accent" stroke="currentColor" />
        <path d="M8 82h184" stroke-dasharray="1 5" />
        <path d="M30 76l4 6M170 76l-4 6" />
        <circle cx="100" cy="82" r="1.5" />
        <path d="M60 18h20M120 18h20" stroke-dasharray="2 4" />
    @elseif($name === 'project')
        {{-- A page wireframe on a blueprint with a ruler and a pencil. --}}
        <rect x="30" y="8" width="112" height="76" rx="6" />
        <path d="M30 22h112" />
        <circle cx="39" cy="15" r="1.6" />
        <circle cx="46" cy="15" r="1.6" />
        <circle cx="53" cy="15" r="1.6" />
        <rect x="40" y="30" width="56" height="8" rx="2" class="text-ink" stroke="currentColor" />
        <path d="M40 46h40M40 52h30" />
        <rect x="40" y="60" width="26" height="12" rx="3" class="text-accent" stroke="currentColor" />
        <rect x="104" y="30" width="28" height="22" rx="3" />
        <path d="M104 44l8-7 7 6 5-4 8 8" class="text-moss" stroke="currentColor" />
        <rect x="104" y="58" width="28" height="14" rx="3" />
        <path d="M20 8v76M16 8h8M16 84h8" stroke-dasharray="2 3" />
        <path d="M30 92h112M30 88v8M142 88v8" stroke-dasharray="2 3" />
        <path d="M164 70l22-44 6 3-22 44-8 3z" />
        <path d="M168 62l6 3M186 26l6 3" />
        <path d="M156 84h40" stroke-dasharray="1 5" />
        <path d="M158 20l4 4M170 12l-3 5" class="text-accent" stroke="currentColor" />
    @else
        {{-- A loop of regular check-ins: two weeks of days, two marked, a cycle arrow above. --}}
        <path d="M80 30a20 20 0 0 1 40 0M115 22l5 8-9 2" class="text-moss" stroke="currentColor" />
        <path d="M120 30a20 20 0 0 1-40 0M85 38l-5-8 9-2" class="text-moss" stroke="currentColor" opacity="0.55" />
        <circle cx="100" cy="30" r="6" class="text-accent" stroke="currentColor" />
        <path d="M97 30l2 2 4-4" class="text-accent" stroke="currentColor" />
        @foreach(range(0, 6) as $i)
            <rect x="{{ 14 + $i * 25 }}" y="58" width="19" height="14" rx="3" />
            <rect x="{{ 14 + $i * 25 }}" y="76" width="19" height="14" rx="3" />
        @endforeach
        <path d="M65 62l4 4 7-8M115 80l4 4 7-8" class="text-moss" stroke="currentColor" />
        <path d="M14 52h172" stroke-dasharray="1 5" />
        <path d="M24 12h22M24 18h14" />
    @endif
</svg>
