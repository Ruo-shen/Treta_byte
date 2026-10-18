{{-- Sticky paper note in Caveat handwriting. Props: tilt (left|right|none), tape. --}}
@props(['tilt' => 'right', 'tape' => true])
<div {{ $attributes->class([
    'relative bg-note p-6 font-hand text-[24px] leading-[1.25] text-ink/80 shadow-[0_14px_30px_-18px_rgba(23,25,27,0.35)] ring-1 ring-ink/[0.04]',
    match ($tilt) { 'left' => '-rotate-2', 'right' => 'rotate-2', default => '' },
]) }}>
    @if($tape)<span class="absolute -top-2.5 left-1/2 h-6 w-14 -translate-x-1/2 -rotate-6 bg-sage/45" aria-hidden="true"></span>@endif
    {{ $slot }}
</div>
