<form method="POST" action="{{ route('contact.store') }}" data-inquiry-form class="space-y-7 inquiry-fields">
    @csrf
    <div class="honeypot" aria-hidden="true">
        <label for="website">Website</label>
        <input id="website" name="website" tabindex="-1" autocomplete="off" value="">
    </div>
    <div class="grid gap-7 sm:grid-cols-2">
        <div>
            <label for="name" class="mb-2 block text-[15px]">Name <span aria-hidden="true">*</span></label>
            <input id="name" class="field" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="100" required @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
            @error('name')
                <p id="name-error" class="mt-2 text-[14px] text-[#a63326]">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="email" class="mb-2 block text-[15px]">Email <span aria-hidden="true">*</span></label>
            <input id="email" class="field" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="255" required @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
            @error('email')
                <p id="email-error" class="mt-2 text-[14px] text-[#a63326]">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div>
        <label for="company" class="mb-2 block text-[15px]">Company <span class="text-muted">(optional)</span></label>
        <input id="company" class="field" name="company" value="{{ old('company') }}" autocomplete="organization" maxlength="150" @error('company') aria-invalid="true" aria-describedby="company-error" @enderror>
        @error('company')
            <p id="company-error" class="mt-2 text-[14px] text-[#a63326]">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="topic" class="mb-2 block text-[15px]">What do you need? <span aria-hidden="true">*</span></label>
        <select id="topic" name="topic" class="field" required @error('topic') aria-invalid="true" aria-describedby="topic-error" @enderror>
            @foreach($topics as $value => $label)
                <option value="{{ $value }}" @selected(old('topic', request('topic', 'general')) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('topic')
            <p id="topic-error" class="mt-2 text-[14px] text-[#a63326]">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="message" class="mb-2 block text-[15px]">Tell us a little more <span aria-hidden="true">*</span></label>
        <textarea id="message" name="message" rows="7" class="field resize-y" required minlength="10" maxlength="5000" @error('message') aria-invalid="true" aria-describedby="message-error" @enderror>{{ old('message') }}</textarea>
        @error('message')
            <p id="message-error" class="mt-2 text-[14px] text-[#a63326]">{{ $message }}</p>
        @enderror
    </div>
    <p class="text-[14px] text-muted">Fields marked * are required. Read our <a href="/privacy" class="underline underline-offset-4">privacy information</a> before sending.</p>
    <button type="submit" class="inline-flex min-h-[52px] items-center gap-8 rounded-lg bg-ink px-7 py-3 text-white hover:bg-accent disabled:cursor-wait disabled:opacity-60">Send inquiry <span aria-hidden="true">↗</span></button>
</form>
