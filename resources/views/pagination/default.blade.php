@if($paginator->hasPages())
@php
    $link = 'inline-flex min-h-11 min-w-11 items-center justify-center rounded-full border px-4 text-[15px] transition-colors';
    // Page 1 is the bare /blog URL (keeping an active ?category filter), never ?page=1.
    $first = route('blog.index', array_filter(['category' => request()->query('category')]));
@endphp
<nav aria-label="Pagination" class="flex flex-wrap items-center gap-2">
    @if($paginator->onFirstPage())
        <span class="{{ $link }} border-transparent text-muted/60" aria-hidden="true">← Newer</span>
    @else
        <a href="{{ $paginator->currentPage() === 2 ? $first : $paginator->previousPageUrl() }}" rel="prev" class="{{ $link }} border-ink/20 bg-white hover:border-ink/50">← Newer</a>
    @endif
    @foreach($elements as $element)
        @if(is_string($element))
            <span class="px-1 text-muted" aria-hidden="true">{{ $element }}</span>
        @else
            @foreach($element as $page => $url)
                @if($page == $paginator->currentPage())
                    <span class="{{ $link }} border-ink bg-ink text-white" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $page == 1 ? $first : $url }}" class="{{ $link }} border-ink/20 bg-white hover:border-ink/50" aria-label="Page {{ $page }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach
    @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $link }} border-ink/20 bg-white hover:border-ink/50">Older →</a>
    @else
        <span class="{{ $link }} border-transparent text-muted/60" aria-hidden="true">Older →</span>
    @endif
</nav>
@endif
