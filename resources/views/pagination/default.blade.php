@if($paginator->hasPages())
<nav aria-label="Pagination" class="flex flex-wrap items-center gap-x-6 gap-y-2 font-mono text-[12px] uppercase tracking-widest">
    @if($paginator->onFirstPage())
        <span class="inline-flex min-h-11 items-center text-muted/60" aria-hidden="true">← Newer</span>
    @else
        <a href="{{ $paginator->currentPage() === 2 ? route('blog.index') : $paginator->previousPageUrl() }}" rel="prev" class="inline-flex min-h-11 items-center hover:text-accent">← Newer</a>
    @endif
    @foreach($elements as $element)
        @if(is_string($element))
            <span class="text-muted" aria-hidden="true">{{ $element }}</span>
        @else
            @foreach($element as $page => $url)
                @if($page == $paginator->currentPage())
                    <span class="inline-flex min-h-11 items-center border-b border-ink" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $page == 1 ? route('blog.index') : $url }}" class="inline-flex min-h-11 items-center text-muted hover:text-accent" aria-label="Page {{ $page }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach
    @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex min-h-11 items-center hover:text-accent">Older →</a>
    @else
        <span class="inline-flex min-h-11 items-center text-muted/60" aria-hidden="true">Older →</span>
    @endif
</nav>
@endif
