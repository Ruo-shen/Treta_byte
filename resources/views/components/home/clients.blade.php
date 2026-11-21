@php
    // PLACEHOLDER names only: replace with real client logos (and confirm permission to show them) before launch.
    // Each entry: [name, icon]. Icons are simple generic marks, not anyone's real logo.
    $icons = [
        'star' => '<path d="M12 2v20M2 12h20M5 5l14 14M19 5L5 19" stroke-width="2.2" stroke-linecap="round"/>',
        'pill' => '<rect x="2" y="7" width="20" height="10" rx="5" fill="none" stroke-width="2.6"/>',
        'hex' => '<path d="M12 2l8.7 5v10L12 22l-8.7-5V7z" stroke-width="2.4" fill="none" stroke-linejoin="round"/>',
        'slab' => '<path d="M3 5h12l-3 6H0zM9 13h12l-3 6H6z" stroke="none"/>',
        'spark' => '<path d="M12 1c1 6 5 10 11 11-6 1-10 5-11 11-1-6-5-10-11-11 6-1 10-5 11-11z" stroke="none"/>',
        'ring' => '<circle cx="12" cy="12" r="8.5" fill="none" stroke-width="2.6"/><path d="M3 12h18" stroke-width="2.2"/>',
        'cube' => '<path d="M4 7l8-4 8 4v10l-8 4-8-4zM4 7l8 4 8-4M12 11v10" fill="none" stroke-width="2.2" stroke-linejoin="round"/>',
    ];
    $rows = [
        [['Harborline', 'star'], ['Lumen Studio', 'pill']],
        [['Fieldnote', 'hex'], ['Brightpath', 'slab'], ['Oakline', 'spark']],
        [['Tidewater', 'ring'], ['Kinfolk', 'cube']],
    ];
@endphp
<section class="overflow-hidden bg-cloud py-16 sm:py-24" aria-labelledby="clients-title">
    <div class="mx-auto grid w-full max-w-[1440px] items-center gap-16 px-6 sm:px-8 lg:px-12 lg:grid-cols-[minmax(0,0.85fr)_minmax(0,1.5fr)] lg:gap-8">
        <div class="reveal">
            <p class="text-[15px] font-medium text-accent">Our clients</p>
            <h2 id="clients-title" class="mt-4 max-w-[14ch] font-display text-[clamp(2.4rem,4.4vw,3.6rem)] font-normal leading-[1.1] tracking-[-0.02em]">
                The kinds of teams <span class="text-ink/55">we work with</span>
            </h2>
        </div>
        <div class="au au-oval relative grid gap-16 py-10 lg:gap-24" role="list" aria-label="Example clients">
            @foreach ($rows as $i => $row)
                <div class="au-row" data-dir="{{ $i % 2 ? 'rev' : 'fwd' }}" style="animation-duration: {{ 60 + $i * 12 }}s; animation-delay: {{ -$i * 9 }}s">
                    @foreach ([0, 1] as $group)
                        <div class="au-group" style="gap: 96px; padding-right: 96px">
                            @foreach ([0, 1] as $set)
                                @foreach ($row as [$name, $icon])
                                    @php $real = $group === 0 && $set === 0; @endphp
                                    <div class="au-item gap-3 text-ink/55" @if ($real) role="listitem" @else aria-hidden="true" @endif>
                                        <svg viewBox="0 0 24 24" class="h-8 w-8 shrink-0" fill="currentColor" stroke="currentColor" aria-hidden="true">{!! $icons[$icon] !!}</svg>
                                        <span class="text-[26px] font-semibold tracking-[-0.03em]">{{ $name }}</span>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</section>
