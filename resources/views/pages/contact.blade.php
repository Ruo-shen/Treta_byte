@extends('layouts.app')
@section('content')
<div class="inner-site contact-page">
    <section class="inner-shell contact-layout">
        <div class="contact-letter">
            <p class="kicker">Contact / Start with the problem</p>
            <h1 class="inner-title">Tell us where<br>it gets <span class="text-moss">stuck.</span></h1>
            <p class="inner-lede">A website that keeps breaking. A new idea. Too much work in too many places. A few details are enough to start.</p>
            <div class="contact-next">
                <p class="hand-note">No perfect brief required.</p>
                <h2>What happens next?</h2>
                <ol>
                    <li><span>01</span>We read what you’ve shared.</li>
                    <li><span>02</span>We ask any useful follow-up questions.</li>
                    <li><span>03</span>We discuss a sensible next step.</li>
                </ol>
                <p>A conversation comes before a commitment.</p>
            </div>
        </div>
        <div class="inquiry-paper">
            @if(session('inquiry_sent'))
                <div class="inquiry-receipt" role="status">
                    <span class="receipt-check" aria-hidden="true">✓</span>
                    <p class="kicker">Inquiry received</p>
                    <h2>Your note<br>made it through.</h2>
                    <p>Thanks for explaining what’s going on. We’ll use the email you provided to follow up.</p>
                    <div class="receipt-line">
                        <span>Next step</span><b>A conversation about the work</b>
                    </div>
                    <a class="inner-link" href="{{ route('services.index') }}">Explore what we do ↗</a><a class="inner-link" href="{{ route('contact.show') }}">Send another inquiry</a>
                </div>
            @else
                <div class="paper-heading">
                    <span class="kicker">A note to TRETA Lab</span><span aria-hidden="true">↗</span>
                </div>
                <h2 class="sr-only">Send an inquiry</h2>
                @if($errors->any())
                    <div class="form-errors" role="alert" tabindex="-1">
                        <h3>A few details need attention.</h3>
                        <ul>
                            @foreach($errors->getMessages() as $field => $messages)
                                <li><a href="#{{ $field }}">{{ $messages[0] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @include('components.inquiry-form')
            @endif
        </div>
    </section>
    <div class="inner-shell contact-care">
        <span class="kicker">A small note on privacy</span>
        <p>Only share what helps us understand the request. Please don’t include passwords, payment information or other sensitive details.</p>
        <a href="{{ route('privacy') }}" class="inner-link">Read the privacy information ↗</a>
    </div>
</div>
@endsection
