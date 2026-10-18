@extends('layouts.app')
@section('content')
<div class="inner-site service-detail">
@include('pages.services.details.'.$slug)
<section class="inner-shell section-space scope-section"><div><p class="kicker">A clear scope</p><h2 class="inner-heading">What the work<br>can include.</h2><p class="inner-body">The right scope depends on your setup. We agree what’s included before we start.</p></div><dl class="scope-list">@foreach($service['deliverables'] as $item)<div><dt>{{ $item['name'] }}</dt><dd>{{ $item['description'] }}</dd></div>@endforeach</dl></section>
@if(!empty($projects))<section class="inner-shell pb-20"><p class="kicker">Related work</p>@foreach($projects as $projectSlug => $project)<a class="project-text-link" href="{{ route('work.show', $projectSlug) }}">{{ $project['title'] }} <span aria-hidden="true">↗</span></a>@endforeach</section>@endif
<section class="inner-shell service-closing"><p class="hand-note">Start with what you know. We’ll ask the useful questions.</p><a href="{{ route('contact.show', ['topic' => $service['pillar']]) }}" class="inner-button">Discuss {{ strtolower($service['name']) }} <span aria-hidden="true">↗</span></a><a href="{{ route('services.index') }}" class="inner-link">Explore all services</a></section>
</div>
@endsection
