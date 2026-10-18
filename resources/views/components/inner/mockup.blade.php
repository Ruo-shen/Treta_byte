{{-- Product-style UI card. Props: label (mono title bar), tilt (left|right, tablet and up only), dark. --}}
@props(['label' => null, 'tilt' => null, 'dark' => false])
<div {{ $attributes->class([
    'overflow-hidden rounded-[12px] border shadow-[0_28px_60px_-40px_rgba(23,25,27,0.45)]',
    $dark ? 'on-dark border-white/10 bg-[#25272a] text-white' : 'border-line bg-white',
    match ($tilt) { 'left' => 'md:-rotate-[1.5deg]', 'right' => 'md:rotate-[1.5deg]', default => '' },
]) }}>
    <div class="flex items-center gap-3 border-b px-4 py-3 font-mono text-[12px] {{ $dark ? 'border-white/10 text-white/70' : 'border-line text-muted' }}">
        <span class="flex gap-1.5" aria-hidden="true">
            <span class="h-2.5 w-2.5 rounded-full {{ $dark ? 'bg-white/20' : 'bg-ink/15' }}"></span>
            <span class="h-2.5 w-2.5 rounded-full {{ $dark ? 'bg-white/20' : 'bg-ink/15' }}"></span>
            <span class="h-2.5 w-2.5 rounded-full {{ $dark ? 'bg-white/20' : 'bg-ink/15' }}"></span>
        </span>
        @if($label)<span class="truncate">{{ $label }}</span>@endif
    </div>
    <div class="p-5 sm:p-7">{{ $slot }}</div>
</div>
