{{--
    Trust slots (testimonials, client logos, project teasers) from config/trust.php.
    Real entries render in every environment; when a list is empty its placeholder renders only in APP_ENV=local.
    Renders nothing at all when there is no real content and the app is not local.
--}}
@props(['tone' => 'soft'])
@php
    $t = config('trust');
    $quotes = $t['testimonials'] ?? [];
    $logos = $t['logos'] ?? [];
    $projects = $t['projects'] ?? [];
    $show = $quotes || $logos || $projects || app()->environment('local');
@endphp
@if($show)
    <x-inner.band :tone="$tone" kicker="Clients and projects" {{ $attributes }}>
        <div class="space-y-10">
            @if($quotes)
                <ul class="grid gap-5 md:grid-cols-2">
                    @foreach($quotes as $q)
                        <li>
                            <figure class="h-full rounded-[14px] border border-line bg-white p-6 sm:p-7">
                                <blockquote class="text-[19px] leading-[1.5] tracking-[-0.01em]">{{ $q['quote'] }}</blockquote>
                                <figcaption class="mt-5 text-[15px] text-muted">{{ $q['name'] }}@if(!empty($q['role'])), {{ $q['role'] }}@endif @if(!empty($q['company']))· {{ $q['company'] }}@endif</figcaption>
                            </figure>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-inner.placeholder what="testimonials: real, approved quotes with name, role and company (config/trust.php)" class="min-h-[120px]" />
            @endif
            @if($logos)
                <ul class="flex flex-wrap items-center gap-x-10 gap-y-6">
                    @foreach($logos as $l)
                        <li>
                            @if(!empty($l['href']))<a href="{{ $l['href'] }}" class="inline-flex min-h-11 items-center">@endif
                            <img src="{{ $l['src'] }}" alt="{{ $l['name'] }}" width="{{ $l['width'] }}" height="{{ $l['height'] }}" loading="lazy" class="h-10 w-auto opacity-80">
                            @if(!empty($l['href']))</a>@endif
                        </li>
                    @endforeach
                </ul>
            @else
                <x-inner.placeholder what="client logos: permitted logo files (config/trust.php)" />
            @endif
            @if($projects)
                <ul class="grid gap-5 md:grid-cols-2">
                    @foreach($projects as $p)
                        <li>
                            <a href="{{ $p['href'] }}" class="hn-card group relative block h-full p-6">
                                <h3 class="text-[22px] font-medium tracking-[-0.02em]">{{ $p['title'] }} <span class="text-accent" aria-hidden="true">↗</span></h3>
                                <p class="mt-3 text-[16px] leading-[1.6] text-muted">{{ $p['summary'] }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-inner.placeholder what="project teasers: real, approved project title, summary and link (config/trust.php)" />
            @endif
        </div>
    </x-inner.band>
@endif
