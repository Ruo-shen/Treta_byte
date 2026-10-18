@props(['href', 'variant' => 'ink', 'arrow' => true])
@php
    $styles = [
        'ink' => 'min-h-[52px] rounded-[8px] bg-ink px-6 text-white hover:bg-accent',
        'accent' => 'min-h-[52px] rounded-[8px] bg-accent px-6 text-white hover:bg-accent-hover',
        'link' => 'min-h-11 border-b border-current/40 pb-0.5 hover:border-current',
    ][$variant] ?? '';
@endphp
<a href="{{ $href }}" {{ $attributes->class(['inline-flex items-center justify-center gap-2.5 text-[15.5px] font-medium transition-colors', $styles]) }}>
    {{ $slot }}
    @if($arrow)
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" class="h-3.5 w-3.5 shrink-0" aria-hidden="true">
            <path d="M4.5 11.5l7-7M5.5 4.5h6v6" />
        </svg>
    @endif
</a>
