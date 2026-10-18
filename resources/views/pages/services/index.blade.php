@extends('layouts.app')
@section('content')
<div class="inner-site services-page">
    <section class="inner-shell service-intro">
        <div>
            <p class="kicker">Services / A useful starting point</p>
            <h1 class="inner-title">What needs<br><span class="text-moss">to work better?</span></h1>
            <p class="inner-lede">Sometimes it’s a broken form. Sometimes it’s the whole system. We help you make sense of the problem, then do the work it needs.</p>
        </div>
        <div class="discipline-index" aria-label="Three disciplines">
            <p><span>01</span> Fix <small>Make it right.</small></p>
            <p><span>02</span> Build <small>Make it useful.</small></p>
            <p><span>03</span> Care <small>Keep it working.</small></p>
            <span class="hand-note">Same team. Different starting points.</span>
        </div>
    </section>
    <section class="inner-shell section-space">
        <div class="section-heading">
            <p class="kicker">Find your starting point</p>
            <h2 class="inner-heading">You don’t need to know<br>the technical answer.</h2>
        </div>
        <div class="service-selector">
            <a href="{{ route('services.show', 'website-repair') }}"><span class="index-number">01 / Fix</span>
            <div>
                <h3>“It used to work.”</h3>
                <p>Broken features, slow pages, failed connections. Find the cause and repair it properly.</p>
            </div>
            <span class="round-arrow" aria-hidden="true">↗</span></a> <a href="{{ route('services.show', 'web-development') }}"><span class="index-number">02 / Build</span>
            <div>
                <h3>“We need something better.”</h3>
                <p>A website that explains the business, or a custom tool that helps the team get things done.</p>
                <span class="text-accent">Websites & web applications</span>
            </div>
            <span class="round-arrow" aria-hidden="true">↗</span></a> <a href="{{ route('services.show', 'website-maintenance') }}"><span class="index-number">03 / Care</span>
            <div>
                <h3>“Who’s looking after this?”</h3>
                <p>Ongoing updates, maintenance and support. A clear arrangement with someone accountable.</p>
            </div>
            <span class="round-arrow" aria-hidden="true">↗</span></a>
        </div>
    </section>
    <section class="services-directory section-space">
        <div class="inner-shell">
            <div class="section-heading">
                <p class="kicker">The work, in plain language</p>
                <h2 class="inner-heading">Four ways to move forward.</h2>
            </div>
            <div class="directory-grid">
                @foreach($services as $serviceSlug => $item)
                    <article>
                        <p class="kicker">{{ ucfirst($item['pillar']) }}</p>
                        <h3><a href="{{ route('services.show', $serviceSlug) }}">{{ $item['name'] }} <span aria-hidden="true">↗</span></a></h3>
                        <p>{{ $item['summary'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    <section class="inner-shell engagement-note section-space">
        <div>
            <p class="kicker">Before we begin</p>
            <h2 class="inner-heading">A conversation.<br>Then a clear scope.</h2>
        </div>
        <div>
            <p class="inner-body">We’ll talk through the goal, what you already have, and what’s getting in the way. You should understand the proposed work, its boundaries and the next step before it starts.</p>
            <a href="{{ route('contact.show') }}" class="inner-button">Help me find a starting point <span aria-hidden="true">↗</span></a>
        </div>
    </section>
</div>
@endsection
