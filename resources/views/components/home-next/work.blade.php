{{--
    Work band: real, approved projects (and quotes / client logos) from config/trust.php.
    Renders NOTHING while the config is empty, except a local-only placeholder (APP_ENV=local).
    A project may carry an optional 'image' (path under public/) and 'image_alt'; width/height keep layout stable.
--}}
@php
    $trust = config('trust');
    $projects = $trust['projects'] ?? [];
    $quotes = $trust['testimonials'] ?? [];
    $logos = $trust['logos'] ?? [];
    $hasContent = $projects || $quotes || $logos;
@endphp
@if($hasContent || app()->environment('local'))
    <section id="work" class="hx-section hx-soft scroll-mt-16">
        <div class="hx-wrap">
            <h2 class="hx-reveal">Selected work</h2>
            @if($projects)
                <ul class="mt-10 grid gap-5 sm:mt-12 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($projects as $project)
                        <li class="hx-reveal" style="--i:{{ $loop->index }}">
                            <a href="{{ $project['href'] }}" class="hx-card hx-lift group block h-full p-5">
                                @if(!empty($project['image']))
                                    <img src="{{ $project['image'] }}" width="{{ $project['image_width'] ?? 960 }}" height="{{ $project['image_height'] ?? 600 }}" alt="{{ $project['image_alt'] ?? '' }}" loading="lazy" class="mb-5 aspect-[16/10] w-full rounded-[8px] object-cover">
                                @else
                                    <x-inner.placeholder class="mb-5 aspect-[16/10]" what="project image (owner to supply)" />
                                @endif
                                <h3 class="text-[22px] font-medium leading-tight tracking-[-0.02em]">{{ $project['title'] }}</h3>
                                <p class="mt-2 text-[16px] leading-[1.55] text-muted">{{ $project['summary'] }}</p>
                                <span class="hx-link mt-2">View project <x-inner.icon name="arrow" class="h-4 w-4" /></span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @elseif(app()->environment('local'))
                <x-inner.placeholder class="mt-8" what="work band: approved projects (config/trust.php projects); this band is hidden in production until there is one" />
            @endif
            @if($quotes)
                <ul class="mt-10 grid gap-5 md:grid-cols-2">
                    @foreach($quotes as $quote)
                        <li><figure class="hx-card h-full p-6">
                            <blockquote class="text-[18px] leading-[1.5] tracking-[-0.01em]">{{ $quote['quote'] }}</blockquote>
                            <figcaption class="mt-4 text-[15px] text-muted">{{ $quote['name'] }}@if(!empty($quote['role'])), {{ $quote['role'] }}@endif @if(!empty($quote['company']))· {{ $quote['company'] }}@endif</figcaption>
                        </figure></li>
                    @endforeach
                </ul>
            @endif
            @if($logos)
                <ul class="mt-10 flex flex-wrap items-center gap-x-10 gap-y-6">
                    @foreach($logos as $logo)
                        <li>
                            @if(!empty($logo['href']))<a href="{{ $logo['href'] }}" class="inline-flex min-h-11 items-center">@endif
                            <img src="{{ $logo['src'] }}" alt="{{ $logo['name'] }}" width="{{ $logo['width'] }}" height="{{ $logo['height'] }}" loading="lazy" class="h-10 w-auto opacity-80">
                            @if(!empty($logo['href']))</a>@endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>
@endif
