@extends('layouts.app')
@php($seo = array_merge($seo ?? [], ['robots' => 'noindex,follow']))
@section('content')
@include('components.page-intro', ['eyebrow' => 'Privacy information', 'heading' => 'Your information deserves care.', 'intro' => 'This page is being prepared alongside the inquiry service. Final storage, retention, email delivery, and contact details must be confirmed before launch.'])
<section class="mx-auto max-w-[800px] space-y-10 px-5 py-16 sm:px-8 sm:py-24">
    <div><h2 class="text-[30px] font-medium tracking-tight">Information in an inquiry</h2><p class="mt-4 text-[18px] leading-relaxed text-muted">The form asks for your name, email, an optional company name, a topic, and a message. Please include only what helps explain your request. Do not send passwords, payment details, or other sensitive information.</p></div>
    <div><h2 class="text-[30px] font-medium tracking-tight">Before the service launches</h2><p class="mt-4 text-[18px] leading-relaxed text-muted">We need to confirm how inquiries are stored and delivered, who can access them, how long they are retained, and how you can contact us about your information. This notice will be updated with those details.</p></div>
    <div><h2 class="text-[30px] font-medium tracking-tight">Analytics and external services</h2><p class="mt-4 text-[18px] leading-relaxed text-muted">Analytics configuration and any consent requirements are pending review. This frontend loads fonts from Google Fonts; your browser contacts that service when those fonts are requested.</p></div>
    <p class="border-t border-line pt-7 font-mono text-[12px] leading-relaxed text-muted">Prelaunch notice — final privacy information pending confirmation.</p>
</section>
@endsection
