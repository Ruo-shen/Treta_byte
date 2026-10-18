{{--
    Definition list from [term, description] pairs.
    layout rows: term left, description right, hairline separated (agreements, ledgers, case facts).
    layout grid: mono term over description in 1/2/3 columns (scope, boundaries).
--}}
@props(['items' => [], 'layout' => 'rows', 'dark' => false])
@php
    $line = $dark ? 'border-white/15' : 'border-line';
    $body = $dark ? 'text-white/70' : 'text-muted';
@endphp
@if($layout === 'grid')
    <dl {{ $attributes->class('grid gap-x-10 gap-y-8 sm:grid-cols-2 lg:grid-cols-3') }}>
        @foreach($items as [$term, $description])
            <div class="border-t pt-5 {{ $line }}">
                <dt class="font-mono text-[12px] uppercase tracking-[0.14em] {{ $dark ? 'text-sage' : 'text-accent' }}">{{ $term }}</dt>
                <dd class="mt-3 text-[16px] leading-[1.6] {{ $body }}">{{ $description }}</dd>
            </div>
        @endforeach
    </dl>
@else
    <dl {{ $attributes->class(['border-y', $line]) }}>
        @foreach($items as [$term, $description])
            <div class="grid gap-2 py-6 sm:grid-cols-[minmax(0,0.45fr)_minmax(0,1fr)] sm:gap-10 {{ $loop->first ? '' : 'border-t ' . $line }}">
                <dt class="text-[24px] font-medium leading-tight tracking-[-0.02em]">{{ $term }}</dt>
                <dd class="text-[16px] leading-[1.6] sm:text-[17px] {{ $body }}">{{ $description }}</dd>
            </div>
        @endforeach
    </dl>
@endif
