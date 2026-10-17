{{-- BACKEND STUB (unstyled, no final copy). Frontend owner replaces with layouts/app.blade.php. --}}
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>{{ $seo['title'] }}</title>
<meta name="description" content="{{ $seo['description'] }}">
<meta name="robots" content="{{ $seo['robots'] }}">
<link rel="canonical" href="{{ $seo['canonical'] }}">
<meta property="og:type" content="{{ $seo['type'] }}">
@if ($seo['og_image'])<meta property="og:image" content="{{ $seo['og_image'] }}">@endif
@if ($seo['json_ld'])<script type="application/ld+json">{!! json_encode($seo['json_ld'], JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>@endif
</head>
<body>
@yield('content')
</body>
</html>
