{{--
    Pill navigation row. Scrolls horizontally on phones (vertical padding keeps focus outlines unclipped),
    wraps from sm, or with `stack` turns into a plain vertical list from lg (in-page section navs).
    Props: items as [label, href, active], label (aria-label), stack.
--}}
@props(['items' => [], 'label' => null, 'stack' => false])
<nav aria-label="{{ $label }}" {{ $attributes }}>
    <div class="no-scrollbar -mx-5 -my-2 flex gap-2 overflow-x-auto px-5 py-2 sm:-mx-8 sm:px-8 {{ $stack ? 'lg:mx-0 lg:gap-0 lg:flex-col lg:overflow-visible lg:px-0' : 'sm:mx-0 sm:flex-wrap sm:overflow-visible sm:px-0' }}">
        @foreach($items as [$text, $href, $active])
            <a href="{{ $href }}" @if($active) aria-current="page" @endif class="inline-flex min-h-11 shrink-0 items-center rounded-full border px-4 text-[15px] transition-colors {{ $active ? 'border-ink bg-ink text-white' : 'border-ink/20 bg-white hover:border-ink/50' }} {{ $stack ? 'lg:rounded-none lg:border-0 lg:border-b lg:border-line lg:bg-transparent lg:px-0' : '' }}">{{ $text }}</a>
        @endforeach
    </div>
</nav>
