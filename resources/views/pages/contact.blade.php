@extends('layouts.app')
@section('content')
@include('components.page-intro', ['eyebrow' => 'Start a conversation', 'heading' => 'Tell us what’s going on.', 'intro' => 'A broken website, an idea for something new, or a system that needs care. You don’t need a technical brief to get started.'])
<section class="mx-auto grid max-w-[1320px] gap-12 px-5 py-16 sm:px-8 sm:py-24 lg:grid-cols-[0.8fr_1.2fr] lg:gap-24 lg:px-12">
    <aside><p class="font-hand text-[28px] text-moss">Start with the problem.<br>We’ll take it from there.</p><h2 class="mt-9 text-[25px] font-medium">A useful first conversation.</h2><p class="mt-4 max-w-[350px] text-[17px] leading-relaxed text-muted">Tell us what you’re trying to do, what’s getting in the way, and any timing that matters. Please leave out passwords and sensitive information.</p><a href="/privacy" class="mt-7 inline-flex min-h-11 items-center border-b border-ink/30 text-[15px]">How inquiry information is handled</a></aside>
    <div>
        @if(session('inquiry_sent'))
        <div role="status" class="mb-8 rounded-xl border border-moss/25 bg-sage/20 p-6"><h2 class="text-[25px] font-medium">Thanks for telling us.</h2><p class="mt-3 leading-relaxed">Your inquiry has been received. We’ll be in touch using the email you provided.</p></div>
        @endif
        @if($errors->any())
        <div role="alert" tabindex="-1" class="mb-8 rounded-xl border border-[#a63326]/30 bg-white p-6"><h2 class="text-[22px] font-medium">A few details need attention.</h2><ul class="mt-4 list-disc space-y-2 pl-5">@foreach($errors->all() as $message)<li>{{ $message }}</li>@endforeach</ul></div>
        @endif
        <form method="POST" action="{{ route('contact.store') }}" data-inquiry-form class="space-y-7">
            @csrf
            <div aria-hidden="true" class="absolute -left-[9999px] h-px w-px overflow-hidden"><label for="website">Website</label><input id="website" name="website" type="text" value="" tabindex="-1" autocomplete="off"></div>
            <div class="grid gap-7 sm:grid-cols-2">
                <div><label for="name" class="mb-2 block text-[15px]">Name <span aria-hidden="true">*</span></label><input id="name" class="field" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="100" required @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>@error('name')<p id="name-error" class="mt-2 text-[14px] text-[#a63326]">{{ $message }}</p>@enderror</div>
                <div><label for="email" class="mb-2 block text-[15px]">Email <span aria-hidden="true">*</span></label><input id="email" class="field" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="255" required @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>@error('email')<p id="email-error" class="mt-2 text-[14px] text-[#a63326]">{{ $message }}</p>@enderror</div>
            </div>
            <div><label for="company" class="mb-2 block text-[15px]">Company <span class="text-muted">(optional)</span></label><input id="company" class="field" name="company" value="{{ old('company') }}" autocomplete="organization" maxlength="150" @error('company') aria-invalid="true" aria-describedby="company-error" @enderror>@error('company')<p id="company-error" class="mt-2 text-[14px] text-[#a63326]">{{ $message }}</p>@enderror</div>
            <div><label for="topic" class="mb-2 block text-[15px]">What do you need? <span aria-hidden="true">*</span></label><select id="topic" name="topic" class="field" required @error('topic') aria-invalid="true" aria-describedby="topic-error" @enderror>@foreach($topics as $value => $label)<option value="{{ $value }}" @selected(old('topic', request('topic', 'general')) === $value)>{{ $label }}</option>@endforeach</select>@error('topic')<p id="topic-error" class="mt-2 text-[14px] text-[#a63326]">{{ $message }}</p>@enderror</div>
            <div><label for="message" class="mb-2 block text-[15px]">Tell us a little more <span aria-hidden="true">*</span></label><textarea id="message" name="message" rows="7" class="field resize-y" required minlength="10" maxlength="5000" @error('message') aria-invalid="true" aria-describedby="message-error" @enderror>{{ old('message') }}</textarea>@error('message')<p id="message-error" class="mt-2 text-[14px] text-[#a63326]">{{ $message }}</p>@enderror</div>
            <p class="text-[14px] text-muted">Fields marked * are required. Read our <a href="/privacy" class="underline underline-offset-4">privacy information</a> before sending.</p>
            <button type="submit" class="inline-flex min-h-[52px] items-center gap-8 rounded-lg bg-ink px-7 py-3 text-white hover:bg-accent disabled:cursor-wait disabled:opacity-60">Send inquiry <span aria-hidden="true">↗</span></button>
        </form>
    </div>
</section>
@endsection
