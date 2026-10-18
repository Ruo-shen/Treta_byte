@php
    $fieldLabels = ['name' => 'Name', 'email' => 'Email', 'company' => 'Company', 'topic' => 'What you need', 'message' => 'Message'];
@endphp
<form method="POST" action="{{ route('contact.store') }}" data-inquiry-form class="space-y-6">
    @csrf
    <div class="honeypot" aria-hidden="true">
        <label for="website">Website</label>
        <input id="website" name="website" tabindex="-1" autocomplete="off" value="">
    </div>
    @if($errors->any())
        <div role="alert" tabindex="-1" data-focus-on-load class="flex flex-wrap items-center gap-x-3 gap-y-1 rounded-[10px] border border-danger/40 bg-[#fdf6f4] px-4 py-3 text-[15px] text-danger">
            <p class="font-medium">Please check:</p>
            <ul class="flex flex-wrap gap-x-4">
                @foreach($errors->keys() as $field)
                    <li><a href="#{{ $field }}" class="inline-flex min-h-11 items-center underline underline-offset-4">{{ $fieldLabels[$field] ?? ucfirst($field) }}</a></li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label for="name" class="mb-2 block text-[15px] font-medium">Name <span aria-hidden="true">*</span></label>
            <input id="name" class="field" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="100" required @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
            @error('name')
                <p id="name-error" class="mt-2 text-[15px] leading-snug text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="email" class="mb-2 block text-[15px] font-medium">Email <span aria-hidden="true">*</span></label>
            <input id="email" class="field" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="255" required @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
            @error('email')
                <p id="email-error" class="mt-2 text-[15px] leading-snug text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div>
        <label for="company" class="mb-2 block text-[15px] font-medium">Company <span class="font-normal text-muted">(optional)</span></label>
        <input id="company" class="field" name="company" value="{{ old('company') }}" autocomplete="organization" maxlength="150" @error('company') aria-invalid="true" aria-describedby="company-error" @enderror>
        @error('company')
            <p id="company-error" class="mt-2 text-[15px] leading-snug text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="topic" class="mb-2 block text-[15px] font-medium">What do you need? <span aria-hidden="true">*</span></label>
        <select id="topic" name="topic" class="field" required @error('topic') aria-invalid="true" aria-describedby="topic-error" @enderror>
            @foreach($topics as $value => $label)
                <option value="{{ $value }}" @selected(old('topic', array_key_exists((string) request('topic'), $topics) ? request('topic') : 'general') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('topic')
            <p id="topic-error" class="mt-2 text-[15px] leading-snug text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="message" class="mb-2 block text-[15px] font-medium">Tell us a little more <span aria-hidden="true">*</span></label>
        <textarea id="message" name="message" rows="6" class="field resize-y" required minlength="10" maxlength="5000" @error('message') aria-invalid="true" aria-describedby="message-error" @enderror>{{ old('message') }}</textarea>
        @error('message')
            <p id="message-error" class="mt-2 text-[15px] leading-snug text-danger">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="inline-flex min-h-[54px] w-full items-center justify-center gap-3 rounded-[10px] bg-ink px-7 text-[16px] font-medium text-white transition-colors hover:bg-accent disabled:cursor-wait disabled:opacity-60 sm:w-auto">Send inquiry <span aria-hidden="true">↗</span></button>
    <p class="text-[15px] leading-[1.6] text-muted">Fields marked * are required. Only share what helps us understand the request, and please leave out passwords, payment information and other sensitive details. <a href="{{ route('privacy') }}" class="inline-flex min-h-11 items-center underline underline-offset-4">Privacy information</a></p>
</form>
