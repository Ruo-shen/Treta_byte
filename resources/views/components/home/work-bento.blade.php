@php
    // Real, approved projects only (config/work.php, 'enabled' => true, cover image required).
    $all = \App\Http\Controllers\WorkController::enabledProjects();
    $real = array_values(array_filter(
        array_map(fn ($slug, $p) => $p + ['slug' => $slug], array_keys($all), $all),
        fn ($p) => ! empty($p['image']),
    ));

    // DUMMY previews, local environment only, so the layout can be judged before real work exists.
    // Never rendered in production or testing; remove once real projects are enabled.
    $isDummy = ! $real && app()->environment('local');
    if ($isDummy) {
        $covers = ['glass-blue', 'desk-laptop', 'sky-cumulus', 'desk-marble', 'glass-tower', 'sky-rays'];
        $services = ['web-development', 'website-repair', 'website-maintenance', 'web-applications'];
        foreach ($covers as $i => $c) {
            $real[] = ['slug' => null, 'title' => 'Sample project '.str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT), 'summary' => 'Placeholder description for layout preview only.', 'service' => $services[$i % 4], 'image' => 'images/hero/'.$c.'.webp', 'image_width' => 520, 'image_height' => 347];
        }
    }
    $real = array_slice($real, 0, 6);
    // Bento footprint on lg: featured, two stacked, then three across.
    $spans = ['lg:col-span-7 lg:row-span-2', 'lg:col-span-5', 'lg:col-span-5', 'lg:col-span-4', 'lg:col-span-4', 'lg:col-span-4'];
@endphp
@if (! $real)
    @include('components.home.work')
@else
<section id="work" class="wkb scroll-mt-20 overflow-clip bg-cloud py-16 sm:py-24" aria-labelledby="work-title">
    <div class="mx-auto w-full max-w-[1440px] px-6 sm:px-8 lg:px-12">
        <div class="reveal flex flex-col gap-8 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-[15px] font-medium text-accent">Selected work</p>
                <h2 id="work-title" class="mt-4 font-display text-[clamp(2.4rem,4.4vw,3.6rem)] font-normal leading-[1.1] tracking-[-0.02em]">Here's <span class="text-ink/55">our work</span></h2>
            </div>
            <a href="{{ route('work.index') }}" class="inline-flex min-h-11 items-center self-start rounded-full bg-white px-6 text-[15px] font-medium text-ink shadow-[0_8px_24px_-12px_rgba(9,101,156,0.35)] ring-1 ring-line transition-colors duration-200 hover:bg-mist sm:self-auto">All work →</a>
        </div>

        <ul class="mt-16 grid gap-6 lg:grid-cols-12 lg:grid-rows-[repeat(2,minmax(0,1fr))_auto] lg:gap-8" role="list">
            @foreach ($real as $i => $p)
                @php
                    $service = config('services.offerings.'.($p['service'] ?? '').'.name');
                    $href = $p['slug'] ? route('work.show', $p['slug']) : route('work.index');
                    $feature = $i === 0;
                @endphp
                <li class="wkb-tile {{ $spans[$i] }}" style="--i: {{ $i }}">
                    <a href="{{ $href }}" class="wkb-card group {{ $feature ? 'wkb-card--feature' : '' }}">
                        <img src="{{ asset($p['image']) }}" alt="" width="{{ $p['image_width'] ?? 520 }}" height="{{ $p['image_height'] ?? 347 }}" loading="lazy" decoding="async" class="wkb-img">
                        <span class="wkb-glass">
                            <span class="min-w-0">
                                <span class="block font-display {{ $feature ? 'text-[clamp(1.6rem,2.4vw,2.2rem)]' : 'text-[20px]' }} leading-[1.1] tracking-[-0.01em] text-ink">{{ $p['title'] }}</span>
                                @if ($feature && ! empty($p['summary']))
                                    <span class="mt-2 block max-w-[48ch] text-[15px] leading-[1.45] text-ink/70">{{ $p['summary'] }}</span>
                                @endif
                                @if ($service)
                                    <span class="mt-3 inline-block rounded-full bg-white/70 px-3 py-1 text-[12px] font-medium text-ink ring-1 ring-white/70">{{ $service }}</span>
                                @endif
                            </span>
                            <span class="wkb-arrow" aria-hidden="true"><svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4"><path d="M3 13L13 3M5 3h8v8" /></svg></span>
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
        @if ($isDummy)
            <p class="mt-6 text-[12px] text-muted">Sample projects, local preview only</p>
        @endif
    </div>
</section>
@endif
