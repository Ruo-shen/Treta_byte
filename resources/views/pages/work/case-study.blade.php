@extends('layouts.app')
@section('content')
<div class="inner-site case-page">
    <article>
        <header class="inner-shell case-opening">
            <a href="{{ route('work.index') }}" class="inner-link">← The project archive</a>
            <p class="kicker mt-10">{{ isset($project['service']) ? str_replace('-', ' ', $project['service']) : 'Case study' }}</p>
            <h1 class="inner-title">{{ $project['title'] }}</h1>
            <p class="inner-lede">{{ $project['summary'] }}</p>
            <dl class="case-facts">
                @foreach(($project['facts'] ?? []) as $label => $value)
                    <div>
                        <dt>{{ $label }}</dt>
                        <dd>{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </header>
        @if(!empty($project['image']))
            <figure class="inner-shell case-cover">
                <img src="{{ asset($project['image']) }}" alt="{{ $project['image_alt'] ?? '' }}" width="1600" height="1000">
                @if(!empty($project['image_caption']))
                    <figcaption>
                        {{ $project['image_caption'] }}
                    </figcaption>
                @endif
            </figure>
        @endif
        <div class="inner-shell case-story">
            <nav aria-label="Case study sections">
                <p class="kicker">Inside the project</p>
                @foreach(($project['chapters'] ?? []) as $chapter)
                    <a href="#{{ $chapter['id'] }}">{{ $chapter['title'] }}</a>
                @endforeach
            </nav>
            <div>
                @foreach(($project['chapters'] ?? []) as $chapter)
                    <section id="{{ $chapter['id'] }}">
                        <p class="index-number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                        <h2 class="inner-heading">{{ $chapter['title'] }}</h2>
                        @foreach($chapter['paragraphs'] as $paragraph)
                            <p class="inner-body">{{ $paragraph }}</p>
                        @endforeach
                        @if(!empty($chapter['points']))
                            <ul class="checklist">
                                @foreach($chapter['points'] as $point)
                                    <li>{{ $point }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </section>
                @endforeach
            </div>
        </div>
        @if(!empty($project['outcomes']))
            <section class="case-outcomes section-space">
                <div class="inner-shell two-column">
                    <div>
                        <p class="kicker">What changed</p>
                        <h2 class="inner-heading">The outcome,<br>in plain language.</h2>
                    </div>
                    <ul class="checklist">
                        @foreach($project['outcomes'] as $outcome)
                            <li>{{ $outcome }}</li>
                        @endforeach
                    </ul>
                </div>
            </section>
        @endif
    </article>
    <section class="inner-shell case-next section-space">
        <p class="kicker">A similar challenge?</p>
        <h2 class="inner-heading">Your situation will be different.<br>Let’s understand it.</h2>
        <a href="{{ route('contact.show') }}" class="inner-button">Tell us about your project ↗</a>
        @if(!empty($project['service']))
            <a href="{{ route('services.show', $project['service']) }}" class="inner-link">Explore the related service ↗</a>
        @endif
    </section>
</div>
@endsection
