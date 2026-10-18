@php
    // [title, text, tint, accent, icon path]. The old canvas diagram scaled its text down to 6-10px, so the four disciplines are cards now.
    $disciplines = [
        ['Design', 'Turns ideas into simple experiences.', '#e3e9fb', '#315ceb', 'M9 18h6M10 21h4M12 3a6 6 0 0 0-3.5 10.9c.6.5 1 1.2 1 2V16h5v-.1c0-.8.4-1.5 1-2A6 6 0 0 0 12 3z'],
        ['Technical direction', 'Understands your setup and goals.', '#ece6fb', '#7c4ee6', 'M5 20V10M10 20V5M15 20v-7M20 20V8M4 20h17'],
        ['Engineering', 'Builds useful, reliable systems.', '#dcf1ec', '#0f9488', 'M8 7l-5 5 5 5M16 7l5 5-5 5M14 4l-4 16'],
        ['Support', 'Keeps everything running smoothly.', '#fbe9dc', '#d9570b', 'M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6zM12 2v3M12 19v3M4.2 4.2l2.1 2.1M17.7 17.7l2.1 2.1M2 12h3M19 12h3M4.2 19.8l2.1-2.1M17.7 6.3l2.1-2.1'],
    ];
@endphp
<section id="about" class="scroll-mt-16 overflow-x-clip bg-paper py-14 sm:py-[100px]">
    <div class="mx-auto w-full max-w-[1320px] px-5 sm:px-8 lg:px-12">
        <div class="grid items-center gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:gap-16">
            <div class="reveal">
                <x-inner.kicker>About TRETA</x-inner.kicker>
                <h2 class="mt-6 text-[clamp(2.2rem,6vw,3.4rem)] font-medium leading-[1.08] tracking-[-0.045em]">A small, senior studio.<br><span class="text-ink/40">You talk directly to the people doing the work.</span></h2>
                <p class="mt-6 max-w-[530px] text-[17px] leading-[1.6] text-muted sm:mt-9 sm:text-[18px]">A small team taking responsibility from the first conversation onward.</p>
            </div>
            <div class="reveal relative">
                <div aria-hidden="true" class="hn-dots absolute -right-3 -top-6 hidden h-20 w-20 sm:block"></div>
                <ul class="relative grid gap-3 sm:grid-cols-2 sm:gap-4">
                    @foreach($disciplines as [$title, $text, $tint, $accent, $path])
                        <li class="flex items-start gap-4 rounded-[14px] bg-white p-4 sm:block sm:p-5 shadow-[0_12px_32px_-24px_rgba(23,25,27,0.25)] ring-1 ring-line/60 {{ $loop->even ? 'sm:mt-8' : '' }}">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-[12px]" style="background:{{ $tint }};color:{{ $accent }}" aria-hidden="true">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $path }}" /></svg>
                            </span>
                            <div class="min-w-0 sm:contents">
                            <p class="sm:mt-4 flex items-center gap-2.5 text-[18px] font-medium tracking-[-0.01em]"><span class="h-2 w-2 rounded-full" style="background:{{ $accent }}"></span>{{ $title }}</p>
                            <p class="mt-1.5 pl-[18px] text-[15px] leading-[1.45] text-muted">{{ $text }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <p class="sr-only">Design, technical direction, engineering and support are disciplines we bring together, not individual staff profiles.</p>
            </div>
        </div>
    </div>
</section>
