{{--
    Dotted-grid drawing surface for thin SVG sketches. Slots: default (the drawing), note (optional sticky note).
    The note overlaps the corner from sm up and sits below the drawing on phones. Props: label (mono caption).
--}}
@props(['label' => null])
<figure {{ $attributes->class(['relative', isset($note) ? 'sm:pb-8' : '']) }}>
    <div class="rounded-[14px] border border-line bg-soft p-5 [background-image:radial-gradient(rgba(23,25,27,0.16)_1px,transparent_1.2px)] [background-size:14px_14px] sm:p-8">{{ $slot }}</div>
    @if($label)<figcaption class="mt-3 font-mono text-[12px] uppercase tracking-[0.14em] text-muted">{{ $label }}</figcaption>@endif
    @isset($note)
        <x-inner.note tilt="left" class="mt-5 max-w-[280px] sm:absolute sm:bottom-0 sm:right-4 sm:mt-0">{{ $note }}</x-inner.note>
    @endisset
</figure>
