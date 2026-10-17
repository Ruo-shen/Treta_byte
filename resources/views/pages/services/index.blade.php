@extends('layouts.app')
@section('content')
@include('components.page-intro', ['eyebrow' => 'Services / Fix · Build · Care', 'heading' => 'Useful technology. Properly looked after.', 'intro' => 'A one-off repair, a new website, or someone to keep things running. Start with the problem; we’ll work out the right next step together.'])
@include('components.home.services')
<section class="mx-auto max-w-[1320px] px-5 pb-20 sm:px-8 lg:px-12" aria-labelledby="service-directory">
    <h2 id="service-directory" class="mb-8 text-[32px] font-medium tracking-tight">Find the right starting point.</h2>
    @foreach($services as $service)
    <a href="{{ route('services.show', $service['slug']) }}" class="group grid gap-3 border-t border-line py-8 sm:grid-cols-[100px_1fr_1fr_40px] sm:gap-7">
        <span class="font-mono text-[12px] text-accent">{{ $service['pillar'] }}</span>
        <h3 class="text-[26px] tracking-tight">{{ $service['name'] }}</h3>
        <p class="max-w-[440px] text-[16px] leading-relaxed text-muted">{{ $service['summary'] }}</p>
        <span class="text-[24px] text-accent" aria-hidden="true">↗</span>
    </a>
    @endforeach
</section>
@include('components.cta')
@endsection
