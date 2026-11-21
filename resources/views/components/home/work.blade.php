@php
    // Approved projects only (config/work.php, 'enabled' => true). With none, the section shows an honest empty state.
    $projects = $projects ?? \App\Http\Controllers\WorkController::enabledProjects();
    $rows = array_values(array_map(fn ($slug, $p) => $p + ['slug' => $slug], array_keys($projects), $projects));
    $previews = array_values(array_filter($rows, fn ($p) => ! empty($p['image'])));
@endphp
<section id="work" class="scroll-mt-20 overflow-clip bg-cloud py-16 sm:py-24" aria-labelledby="work-title">
    <div class="mx-auto w-full max-w-[1440px] px-6 sm:px-8 lg:px-12">
        <div class="reveal flex flex-col gap-8 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-[15px] font-medium text-accent">Selected work</p>
                <h2 id="work-title" class="mt-4 max-w-[16ch] font-display text-[clamp(2.4rem,4.4vw,3.6rem)] font-normal leading-[1.1] tracking-[-0.02em]">
                    @if ($rows)
                        Here's <span class="text-ink/55">our work</span>
                    @else
                        Good work deserves <span class="text-ink/55">a proper introduction.</span>
                    @endif
                </h2>
            </div>
            <a href="{{ route('work.index') }}" class="inline-flex min-h-11 items-center self-start rounded-full bg-white px-6 text-[15px] font-medium text-ink shadow-[0_8px_24px_-12px_rgba(9,101,156,0.35)] ring-1 ring-line transition-colors duration-200 hover:bg-mist sm:self-auto">All work →</a>
        </div>

        @if ($rows)
            <ol class="wk-list mt-16 border-t border-ink/15" data-work-list>
                @foreach ($rows as $i => $p)
                    @php $service = config('services.offerings.'.($p['service'] ?? '').'.name'); @endphp
                    <li class="wk-row border-b border-ink/15" data-work-row data-index="{{ $i }}">
                        <a href="{{ route('work.show', $p['slug']) }}" class="group grid items-center gap-x-8 gap-y-3 py-8 sm:grid-cols-[48px_1fr_auto] sm:py-10">
                            <span class="hidden font-mono text-[13px] text-muted sm:block">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="min-w-0">
                                <span class="block font-display text-[clamp(2rem,4.6vw,4rem)] font-normal leading-[1.05] tracking-[-0.02em]">{{ $p['title'] }}</span>
                                @if (! empty($p['summary']))
                                    <span class="mt-3 block max-w-[60ch] text-[15px] leading-[1.5] text-muted">{{ $p['summary'] }}</span>
                                @endif
                            </span>
                            <span class="flex items-center gap-4">
                                @if ($service)
                                    <span class="rounded-full bg-white px-4 py-1.5 text-[13px] font-medium text-ink ring-1 ring-line/70">{{ $service }}</span>
                                @endif
                                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"><path d="M2.5 8h11M9 3.5L13.5 8 9 12.5" /></svg>
                            </span>
                            @if (! empty($p['image']))
                                <img src="{{ asset($p['image']) }}" alt="" width="{{ $p['image_width'] ?? 800 }}" height="{{ $p['image_height'] ?? 500 }}" loading="lazy" decoding="async" class="wk-thumb mt-2 aspect-[16/10] w-full rounded-[18px] object-cover sm:col-span-3">
                            @endif
                        </a>
                    </li>
                @endforeach
            </ol>

            @if ($previews)
                {{-- Cursor-following preview (fine pointers only); each row's cover is swapped in on hover or focus. --}}
                <div class="wk-preview" data-work-preview aria-hidden="true">
                    @foreach ($previews as $p)
                        <img src="{{ asset($p['image']) }}" alt="" width="{{ $p['image_width'] ?? 800 }}" height="{{ $p['image_height'] ?? 500 }}" loading="lazy" decoding="async" data-slug="{{ $p['slug'] }}">
                    @endforeach
                </div>
            @endif
        @else
            <div class="reveal mt-16 grid gap-12 lg:grid-cols-[1fr_1fr] lg:gap-24">
                <div>
                    <p class="max-w-[46ch] text-[17px] leading-[1.6] text-muted">We'll share project stories here when they're ready to be published. In the meantime, tell us what you're working on.</p>
                    <a href="{{ route('contact.show') }}" class="mt-8 inline-flex min-h-12 items-center gap-2 rounded-full bg-pop px-7 text-[15px] font-medium text-white shadow-[0_12px_24px_-12px_rgba(205,74,66,0.7)] transition-colors duration-200 hover:bg-pop-hover">Discuss your project <span aria-hidden="true">↗</span></a>
                </div>
                {{-- Decorative outline of the list that will live here; carries no project content. --}}
                <ol class="border-t border-ink/15" aria-hidden="true">
                    @foreach (['01', '02', '03'] as $n)
                        <li class="flex items-center justify-between gap-6 border-b border-ink/15 py-7">
                            <span class="font-mono text-[13px] text-muted">{{ $n }}</span>
                            <span class="h-3 flex-1 rounded-full bg-ink/[0.06]"></span>
                            <span class="text-[13px] text-muted">In preparation</span>
                        </li>
                    @endforeach
                </ol>
            </div>
        @endif
    </div>
</section>
