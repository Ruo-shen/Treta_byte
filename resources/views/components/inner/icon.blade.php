{{--
    Thin-line icon set (24px grid, 1.6 stroke, currentColor). Decorative by default (aria-hidden); pass title for an informative icon.
    Props: name, title. Names: fix, build, care (service pillars), arrow, check, plus, mail, phone, location, clock.
    Size with classes (default h-5 w-5).
--}}
@props(['name', 'title' => null])
@php
    $paths = [
        'fix' => 'M14.7 6.3a4 4 0 0 0-5.4 5.4L4 17l3 3 5.3-5.3a4 4 0 0 0 5.4-5.4l-2.5 2.5-2.4-.6-.6-2.4z',
        'build' => 'M12 3l8 4.5v9L12 21l-8-4.5v-9zM4 7.5l8 4.5 8-4.5M12 12v9',
        'care' => 'M20 11a8 8 0 0 0-14.5-4.5M4 4v3h3M4 13a8 8 0 0 0 14.5 4.5M20 20v-3h-3',
        'arrow' => 'M4 12h15M13 6l6 6-6 6',
        'check' => 'M5 12.5l4.5 4.5L19 7',
        'plus' => 'M12 5v14M5 12h14',
        'mail' => 'M3.5 6h17v12h-17zM3.5 7l8.5 6.5L20.5 7',
        'phone' => 'M6 3.5h3l1.5 4-2 1.5a11 11 0 0 0 6.5 6.5l1.5-2 4 1.5v3a2 2 0 0 1-2 2A16 16 0 0 1 4 5.5a2 2 0 0 1 2-2z',
        'location' => 'M12 21s-6.5-5.8-6.5-11a6.5 6.5 0 0 1 13 0c0 5.2-6.5 11-6.5 11zM12 7.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5z',
        'clock' => 'M12 3.5a8.5 8.5 0 1 0 0 17 8.5 8.5 0 0 0 0-17zM12 7.5V12l3 2',
    ];
@endphp
<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" {{ $attributes->class('h-5 w-5 shrink-0') }} @if($title) role="img" aria-label="{{ $title }}" @else aria-hidden="true" @endif><path d="{{ $paths[$name] ?? '' }}" /></svg>
