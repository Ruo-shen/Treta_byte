@php
    $seo = array_merge([
        'title' => 'TRETA Lab — Fix. Build. Care.',
        'description' => 'A technology solutions studio. We fix what is broken, build what is needed, and care for what matters.',
        'canonical' => url()->current(),
        'robots' => 'index,follow',
        'type' => 'website',
    ], $seo ?? []);
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="robots" content="{{ $seo['robots'] }}">
    <link rel="canonical" href="{{ $seo['canonical'] }}">
    <meta property="og:site_name" content="TRETA Lab">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:url" content="{{ $seo['canonical'] }}">
    <meta property="og:type" content="{{ $seo['type'] }}">
    @if(!empty($seo['og_image']))
        <meta property="og:image" content="{{ $seo['og_image'] }}">
    @endif
    @if(!empty($seo['json_ld']))
        <script type="application/ld+json">{!! json_encode($seo['json_ld'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES) !!}</script>
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>
<body id="page-top">
    <a class="skip-link" href="#main-content">Skip to content</a>
    @include('components.header')
    <main id="main-content" tabindex="-1">@yield('content')</main>
    @include('components.footer')
</body>
</html>
