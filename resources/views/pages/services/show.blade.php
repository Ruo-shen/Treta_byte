@extends('layouts.app')
@section('content')
@include('components.page-intro', ['eyebrow' => 'Services / '.$service['pillar'], 'heading' => $service['name'], 'intro' => $service['summary']])
<section class="mx-auto grid max-w-[1320px] gap-12 px-5 py-16 sm:px-8 sm:py-24 lg:grid-cols-[1fr_1.4fr] lg:gap-24 lg:px-12">
    <div><p class="font-mono text-[11px] uppercase tracking-[0.2em] text-accent">Sound familiar?</p><h2 class="mt-5 text-[40px] font-medium leading-[1.1] tracking-[-0.03em]">Start with<br>what isn’t working.</h2></div>
    <ul>@foreach($service['problems'] as $problem)<li class="border-t border-line py-5 text-[21px] leading-relaxed">{{ $problem }}</li>@endforeach</ul>
</section>
<section class="bg-soft py-16 sm:py-24">
    <div class="mx-auto max-w-[1320px] px-5 sm:px-8 lg:px-12">
        <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-accent">What we can help with</p>
        <h2 class="mt-5 text-[40px] font-medium tracking-[-0.03em]">Practical work. Clear scope.</h2>
        <dl class="mt-12 grid gap-x-16 sm:grid-cols-2">@foreach($service['deliverables'] as $item)<div class="border-t border-ink/15 py-8"><dt class="text-[25px] font-medium tracking-tight">{{ $item['name'] }}</dt><dd class="mt-4 max-w-[470px] text-[17px] leading-relaxed text-muted">{{ $item['description'] }}</dd></div>@endforeach</dl>
    </div>
</section>
<section class="mx-auto max-w-[1320px] px-5 py-20 sm:px-8 lg:px-12"><h2 class="text-[32px] font-medium tracking-tight">A clear next step.</h2><p class="mt-5 max-w-[650px] text-[18px] leading-relaxed text-muted">Tell us what you have, what you need, and what’s getting in the way. We’ll discuss the scope before work begins.</p><a href="{{ route('contact.show', ['topic' => strtolower($service['pillar'])]) }}" class="mt-8 inline-flex min-h-12 items-center gap-5 rounded-lg bg-ink px-6 py-3 text-white hover:bg-accent">Discuss {{ strtolower($service['name']) }} <span aria-hidden="true">↗</span></a></section>
@endsection
