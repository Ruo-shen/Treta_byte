@php
    // Placeholder posts until the journal has content. Later: replace with the latest published Post models
    // (title, excerpt, category name, cover image, route('blog.show', $post->slug)) passed in by the controller.
    $insights = [
        ['tag' => 'Care', 'title' => 'Why every website needs a maintenance plan', 'excerpt' => 'Updates, backups and monitoring are cheaper than the emergency they prevent.', 'img' => 'sky-cumulus'],
        ['tag' => 'Fix', 'title' => 'Repair or rebuild? How to decide', 'excerpt' => 'A short checklist for telling a fixable site from one that has reached the end of its life.', 'img' => 'glass-blue'],
        ['tag' => 'Build', 'title' => 'Designing and building without handoff gaps', 'excerpt' => 'How one coordinated team removes the gaps where projects usually slip.', 'img' => 'desk-laptop'],
    ];
@endphp
<section class="bg-cloud py-16 sm:py-24" aria-labelledby="insights-title">
    <div class="mx-auto w-full max-w-[1440px] px-6 sm:px-8 lg:px-12">
        <div class="reveal flex flex-col gap-8 sm:flex-row sm:items-end sm:justify-between">
            <h2 id="insights-title" class="max-w-[16ch] font-display text-[clamp(2.4rem,4.4vw,3.6rem)] font-normal leading-[1.1] tracking-[-0.02em]">
                Ideas, insights <span class="text-ink/55">&amp; perspectives</span>
            </h2>
            <a href="{{ route('blog.index') }}" class="inline-flex min-h-11 items-center self-start rounded-full bg-white px-6 text-[15px] font-medium text-ink shadow-[0_8px_24px_-12px_rgba(9,101,156,0.35)] ring-1 ring-line transition-colors duration-200 hover:bg-mist sm:self-auto">View all articles</a>
        </div>
        <div class="mt-16 grid gap-8 md:grid-cols-3">
            @foreach ($insights as $post)
                <a href="{{ route('blog.index') }}" class="group flex flex-col rounded-[28px] bg-white p-2 shadow-[0_24px_48px_-28px_rgba(9,101,156,0.35)] ring-1 ring-line/70 transition-transform duration-300 hover:-translate-y-1">
                    <div class="flex flex-1 flex-col p-6">
                        <span class="self-start rounded-full bg-cloud px-3 py-1 text-[13px] font-medium text-accent ring-1 ring-line/70">{{ $post['tag'] }}</span>
                        <h3 class="mt-6 font-display text-[26px] font-normal leading-[1.15] tracking-[-0.01em]">{{ $post['title'] }}</h3>
                        <p class="mt-4 max-w-[38ch] text-[15px] leading-[1.5] text-muted">{{ $post['excerpt'] }}</p>
                    </div>
                    <div class="relative aspect-[3/2] overflow-hidden rounded-[22px]">
                        <img src="{{ asset('images/hero/'.$post['img'].'.webp') }}" alt="" width="600" height="400" loading="lazy" decoding="async" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <span class="absolute left-4 top-4 rounded-full bg-white/60 px-4 py-2 text-[13px] font-medium text-ink opacity-0 ring-1 ring-white/70 backdrop-blur-xl transition-opacity duration-300 group-hover:opacity-100 group-focus-visible:opacity-100">Read article</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
