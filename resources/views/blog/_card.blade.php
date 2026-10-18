{{-- One journal card. Needs $post (category loaded). Optional cover image from the public disk. --}}
@php $image = $post->featuredImage(); @endphp
<article class="group relative flex h-full flex-col" @if(!empty($related)) data-related-post @endif>
    @if($image)
        <img src="{{ $image['url'] }}" alt="{{ $post->featured_image_alt }}" width="{{ $image['width'] }}" height="{{ $image['height'] }}" loading="lazy" class="aspect-[16/10] h-auto w-full rounded-[12px] border border-line bg-soft object-cover">
    @else
        <div class="hidden aspect-[16/10] items-end justify-between rounded-[12px] bg-mist p-5 sm:flex" aria-hidden="true">
            <span class="text-[clamp(2rem,4vw,2.6rem)] font-light leading-none tracking-[-0.04em] text-ink/70">{{ $post->published_at->format('j M') }}</span>
            <span class="h-3 w-3 bg-accent"></span>
        </div>
    @endif
    <p class="{{ $image ? 'mt-5' : 'border-t border-ink/15 pt-5 sm:mt-5 sm:border-0 sm:pt-0' }} font-mono text-[12px] uppercase leading-relaxed tracking-[0.12em] text-muted">
        @if($post->category){{ $post->category->name }} · @endif<time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('j M Y') }}</time> · {{ $post->reading_time }} min read
    </p>
    <h3 class="mt-3 text-[24px] font-medium leading-[1.15] tracking-[-0.025em]">
        <a href="{{ route('blog.show', $post->slug) }}" class="flex min-h-11 items-center after:absolute after:inset-0 after:content-['']">{{ $post->title }}</a>
    </h3>
    <p class="mt-3 line-clamp-3 text-[16px] leading-[1.6] text-muted">{{ $post->excerpt }}</p>
</article>
