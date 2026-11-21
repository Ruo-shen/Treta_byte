@php
    $rows = [
        [
            ['Local businesses', 'sky-cloud'], ['Clinics', 'desk-marble'], ['Restaurants', 'glass-blue'],
            ['Startups', 'sky-rays'], ['Consultants', 'desk-laptop'], ['Real estate teams', 'glass-tower'],
        ],
        [
            ['Agencies', 'glass-diagonal'], ['Online shops', 'desk-flatlay'], ['Nonprofits', 'sky-cirrus'],
            ['Schools', 'sky-cumulus'], ['Creative studios', 'desk-marble'],
        ],
    ];
@endphp
<section class="overflow-hidden bg-white py-16 sm:py-24" aria-labelledby="audience-title">
    <div class="mx-auto w-full max-w-[1440px] px-6 sm:px-8 lg:px-12">
        <h2 id="audience-title" class="reveal mx-auto max-w-[22ch] text-center font-display text-[clamp(2rem,3.6vw,3rem)] font-normal leading-[1.1] tracking-[-0.02em]">
            Built for everyone who <span class="text-ink/55">runs on their website</span>
        </h2>
    </div>
    <div class="au mt-16 grid gap-8" role="list" aria-label="Who we work with">
        @foreach ($rows as $i => $row)
            <div class="au-row" data-dir="{{ $i % 2 ? 'rev' : 'fwd' }}">
                {{-- Two identical groups for the seamless loop; each group repeats the set so it is wider than any screen. --}}
                @foreach ([0, 1] as $group)
                    <div class="au-group">
                        @foreach ([0, 1] as $set)
                            @foreach ($row as $k => [$label, $img])
                                @php $real = $group === 0 && $set === 0; @endphp
                                <div class="au-item" @if ($real) role="listitem" @else aria-hidden="true" @endif>
                                    <img src="{{ asset('images/hero/'.$img.'.webp') }}" alt="" width="64" height="64" loading="lazy" decoding="async" class="au-pic" style="--tilt: {{ ($k + $i) % 2 ? '6deg' : '-6deg' }}">
                                    <span class="text-[17px] font-medium text-ink">{{ $label }}</span>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>
