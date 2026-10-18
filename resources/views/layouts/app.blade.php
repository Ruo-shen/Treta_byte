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
    @if(!empty($seo['canonical']))<link rel="canonical" href="{{ $seo['canonical'] }}">@endif
    <meta property="og:site_name" content="TRETA Lab">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    @if(!empty($seo['canonical']))<meta property="og:url" content="{{ $seo['canonical'] }}">@endif
    <meta property="og:type" content="{{ $seo['type'] }}">
    <meta name="twitter:card" content="{{ !empty($seo['og_image']) ? 'summary_large_image' : 'summary' }}">
    @if(!empty($seo['og_image']))
        <meta property="og:image" content="{{ $seo['og_image'] }}">
    @endif
    @if(!empty($seo['json_ld']))
        <script type="application/ld+json">{!! json_encode($seo['json_ld'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES) !!}</script>
    @endif
    @if(filled(config('seo.google_site_verification')))
        <meta name="google-site-verification" content="{{ config('seo.google_site_verification') }}">
    @endif
    @if(app()->isProduction() && empty($preview) && !request()->is('admin', 'admin/*') && preg_match('/^G-[A-Z0-9]{4,20}$/', (string) config('seo.ga4_measurement_id')))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('seo.ga4_measurement_id') }}"></script>
        <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{{ config('seo.ga4_measurement_id') }}');</script>
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300;400;500;600;700&family=Caveat:wght@500&family=JetBrains+Mono:wght@400;500&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>
<body id="page-top">
    <a class="skip-link" href="#main-content">Skip to content</a>
    @include('components.header')
    <main id="main-content" tabindex="-1">@yield('content')</main>
    @include('components.footer')
</body>
</html>
