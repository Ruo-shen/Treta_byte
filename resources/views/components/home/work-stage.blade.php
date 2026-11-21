@php
    // Real, approved projects only (config/work.php, 'enabled' => true, cover image required).
    $real = array_values(array_filter(
        array_map(fn ($slug, $p) => $p + ['slug' => $slug], array_keys(\App\Http\Controllers\WorkController::enabledProjects()), \App\Http\Controllers\WorkController::enabledProjects()),
        fn ($p) => ! empty($p['image']),
    ));

    // DUMMY previews, local environment only, so the layout can be judged before real work exists.
    // Never rendered in production or testing; remove once real projects are enabled.
    $isDummy = ! $real && app()->environment('local');
    if ($isDummy) {
        $covers = ['glass-blue', 'desk-laptop', 'sky-cumulus', 'desk-marble', 'glass-tower', 'sky-rays', 'desk-flatlay', 'glass-diagonal', 'sky-cirrus', 'sky-cloud'];
        $services = ['web-development', 'website-repair', 'website-maintenance', 'web-applications'];
        foreach ($covers as $i => $c) {
            $real[] = ['slug' => null, 'title' => 'Sample project '.str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT), 'service' => $services[$i % 4], 'image' => 'images/hero/'.$c.'.webp', 'image_width' => 520, 'image_height' => 347];
        }
    }
    $real = array_slice($real, 0, 10);

    // Per card: scattered field pose, then deck pose. Lengths are scaled by --u so the scene follows the viewport width.
    $scatter = [[-520, -120, -120, 8, 22, -6], [-300, -250, 80, -10, -18, 5], [-60, -170, -180, 6, 14, 4], [230, -260, 60, -8, -26, -5], [520, -90, -80, 10, -20, 6], [-440, 160, 140, -6, 24, 4], [-150, 110, -60, 12, -12, -7], [120, 150, 160, -8, 18, 5], [380, 220, -100, 6, -24, -4], [610, 120, 120, -12, 16, 7]];
    $n = max(count($real), 1);
@endphp
@if (! $real)
    @include('components.home.work')
@else
<section id="work" class="wk3 scroll-mt-20 bg-cloud" aria-labelledby="work-title">
    <div class="wk3-track">
        <div class="wk3-pin">
            <div class="mx-auto flex w-full max-w-[1440px] flex-col gap-4 px-6 sm:flex-row sm:items-end sm:justify-between sm:px-8 lg:px-12">
                <div>
                    <p class="text-[15px] font-medium text-accent">Selected work</p>
                    <h2 id="work-title" class="mt-2 font-display text-[clamp(2rem,3.6vw,3rem)] font-normal leading-[1.1] tracking-[-0.02em]">Here's <span class="text-ink/55">our work</span></h2>
                </div>
                <a href="{{ route('work.index') }}" class="inline-flex min-h-11 items-center self-start rounded-full bg-white px-6 text-[15px] font-medium text-ink shadow-[0_8px_24px_-12px_rgba(9,101,156,0.35)] ring-1 ring-line transition-colors duration-200 hover:bg-mist sm:self-auto">All work →</a>
            </div>

            <div class="wk3-stage">
                <ul class="wk3-world" role="list">
                    @foreach ($real as $i => $p)
                        @php
                            [$sx, $sy, $sz, $srx, $sry, $srz] = $scatter[$i % count($scatter)];
                            $t = $n > 1 ? $i / ($n - 1) : 0;
                            $focal = abs($t - 0.45);
                            $dry = -60 + max(0, 44 - $focal * 150);
                            $service = config('services.offerings.'.($p['service'] ?? '').'.name');
                            $href = $p['slug'] ? route('work.show', $p['slug']) : route('work.index');
                        @endphp
                        <li class="wk3-card" style="--i: {{ $i }}; --sx: calc(var(--u) * {{ $sx }}); --sy: calc(var(--u) * {{ $sy }}); --sz: calc(var(--u) * {{ $sz }}); --srx: {{ $srx }}deg; --sry: {{ $sry }}deg; --srz: {{ $srz }}deg; --dx: calc(var(--u) * {{ round(-440 + $t * 900) }}); --dy: calc(var(--u) * {{ round(230 - $t * 440) }}); --dz: calc(var(--u) * {{ round(300 - $t * 700) }}); --drx: 10deg; --dry: {{ round($dry) }}deg; --drz: -4deg; z-index: {{ 30 - $i }}">
                            <a href="{{ $href }}" class="wk3-face">
                                <img src="{{ asset($p['image']) }}" alt="" width="{{ $p['image_width'] ?? 520 }}" height="{{ $p['image_height'] ?? 347 }}" loading="lazy" decoding="async">
                                <span class="wk3-meta">
                                    <span class="wk3-title">{{ $p['title'] }}</span>
                                    @if ($service)<span class="wk3-tag">{{ $service }}</span>@endif
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                @if ($isDummy)
                    <p class="wk3-note">Sample projects, local preview only</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endif
