{{-- "What happens next" plus direct-contact stand-in. Rendered once per breakpoint group (left column on desktop, below the form on phones). --}}
<x-inner.note class="max-w-[300px]">No perfect brief required.</x-inner.note>
<h2 class="mt-10 text-[26px] font-medium tracking-[-0.025em]">What happens next?</h2>
<ol class="mt-5 divide-y divide-line border-y border-line">
    @foreach(['We read what you’ve shared.', 'We ask any useful follow-up questions.', 'We discuss a sensible next step.'] as $n => $step)
        <li class="flex items-baseline gap-5 py-4 text-[17px]"><span class="font-mono text-[13px] text-accent">0{{ $n + 1 }}</span>{{ $step }}</li>
    @endforeach
</ol>
<p class="mt-4 text-[16px] text-muted">A conversation comes before a commitment.</p>
<x-inner.placeholder class="mt-8" what="direct contact details (email, phone, location), supplied by the owner" />
