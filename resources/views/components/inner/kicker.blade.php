@props(['dark' => false])
<p {{ $attributes->class(['flex items-center gap-3 font-mono text-[12px] uppercase leading-relaxed tracking-[0.2em]', $dark ? 'text-white/70' : 'text-muted']) }}>
    <span class="h-2 w-2 shrink-0 bg-accent" aria-hidden="true"></span>
    <span>{{ $slot }}</span>
</p>
