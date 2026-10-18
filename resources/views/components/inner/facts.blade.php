{{--
    Definition list from [term, description] pairs.
    layout rows: term left, description right, hairline separated (agreements, ledgers, case facts).
    layout grid: mono term over description in 1/2/3 columns (scope, boundaries).
--}}
@props(['items' => [], 'layout' => 'rows'])
@if($layout === 'grid')
    <dl {{ $attributes->class('grid gap-x-10 gap-y-8 sm:grid-cols-2 lg:grid-cols-3') }}>
        @foreach($items as [$term, $description])
            <div class="border-t border-line pt-5">
                <dt class="font-mono text-[12px] uppercase tracking-[0.14em] text-accent">{{ $term }}</dt>
                <dd class="mt-3 text-[16px] leading-[1.6] text-muted">{{ $description }}</dd>
            </div>
        @endforeach
    </dl>
@else
    <dl {{ $attributes->class('border-y border-line') }}>
        @foreach($items as [$term, $description])
            <div class="grid gap-2 py-6 sm:grid-cols-[minmax(0,0.45fr)_minmax(0,1fr)] sm:gap-10 {{ $loop->first ? '' : 'border-t border-line' }}">
                <dt class="text-[24px] font-medium leading-tight tracking-[-0.02em]">{{ $term }}</dt>
                <dd class="text-[16px] leading-[1.6] text-muted sm:text-[17px]">{{ $description }}</dd>
            </div>
        @endforeach
    </dl>
@endif
