{{-- Local-only stand-in for missing real content. Renders nothing outside APP_ENV=local. Prop: what. --}}
@props(['what'])
@if(app()->environment('local'))
    <div {{ $attributes->class('rounded-[10px] border border-dashed border-muted/60 bg-line p-5 font-mono text-[12px] leading-relaxed text-muted') }} role="note">Content needed: {{ $what }}</div>
@endif
