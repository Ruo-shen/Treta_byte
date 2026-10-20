{{--
    FAQ accordion on native <details>. Data: config('faq.<group>') where group is 'home' or 'services.<slug>'.
    Entries with q/a always render; ['placeholder' => ...] entries render only in APP_ENV=local. Renders nothing when empty.
    Props: group, tone (light|soft), kicker.
--}}
@props(['group', 'tone' => 'light', 'kicker' => 'Questions'])
@php
    $items = collect(config("faq.{$group}", []))->filter(fn ($i) => isset($i['q'], $i['a']) || (isset($i['placeholder']) && app()->environment('local')))->values();
@endphp
@if($items->isNotEmpty())
    <x-inner.band :tone="$tone" {{ $attributes }}>
        <div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr] lg:gap-16">
            <div class="lg:sticky lg:top-28 lg:self-start">
                @if($kicker)<x-inner.kicker>{{ $kicker }}</x-inner.kicker>@endif
                <h2 class="{{ $kicker ? 'mt-5' : '' }} text-[clamp(1.9rem,5.5vw,3.2rem)] font-medium leading-[1.1] tracking-[-0.035em]">Common questions.</h2>
            </div>
            <div class="border-t border-ink/15">
                @foreach($items as $item)
                    @if(isset($item['placeholder']))
                        <x-inner.placeholder class="my-3" :what="$item['placeholder']" />
                    @else
                        <details class="group border-b border-ink/15">
                            <summary class="flex min-h-14 cursor-pointer list-none items-center justify-between gap-6 py-4 text-[18px] font-medium leading-snug tracking-[-0.01em] marker:content-none [&::-webkit-details-marker]:hidden sm:text-[20px]">
                                <span>{{ $item['q'] }}</span>
                                <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full ring-1 ring-ink/20 transition-transform group-open:rotate-45" aria-hidden="true">
                                    <x-inner.icon name="plus" class="h-4 w-4" />
                                </span>
                            </summary>
                            <p class="max-w-[640px] pb-6 text-[16px] leading-[1.65] text-muted sm:text-[17px]">{{ $item['a'] }}</p>
                        </details>
                    @endif
                @endforeach
            </div>
        </div>
    </x-inner.band>
@endif
