{{-- Site footer. `$variant` (set by footer-next) only adds a marker class; the design is shared. --}}
<footer class="ft relative isolate overflow-hidden bg-cloud {{ $variant ?? '' }}">
<div class="sf-grain" aria-hidden="true"></div>
<div class="relative mx-auto w-full max-w-[1440px] px-6 sm:px-8 lg:px-12">
<div class="grid gap-8 pb-16 pt-16 sm:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr]">
<div class="sm:col-span-2 lg:col-span-1">
<p class="flex items-center gap-4 text-[20px] font-medium tracking-[0.5em]"><img src="/images/brand/treta-mark-96.png" alt="" width="28" height="28" class="h-7 w-7" aria-hidden="true" loading="lazy">TRETA</p>
</div>
<nav aria-label="Studio">
<p class="text-[13px] font-medium text-ink/70">Studio</p>
<ul class="mt-4 grid grid-cols-2 sm:block">
<li><a href="/services" class="ft-link">Services</a></li>
<li><a href="/work" class="ft-link">Work</a></li>
<li><a href="/#process" class="ft-link">Process</a></li>
<li><a href="/about" class="ft-link">About</a></li>
<li><a href="/contact" class="ft-link">Contact</a></li>
<li><a href="/blog" class="ft-link">Blog</a></li>
</ul>
</nav>
<nav aria-label="Services">
<p class="text-[13px] font-medium text-ink/70">Services</p>
<ul class="mt-4">
<li><a href="/services/web-development" class="ft-link">Web development</a></li>
<li><a href="/services/website-repair" class="ft-link">Website repair</a></li>
<li><a href="/services/website-maintenance" class="ft-link">Website maintenance</a></li>
<li><a href="/services/web-applications" class="ft-link">Web applications</a></li>
</ul>
</nav>
</div>
<div class="relative z-10 flex flex-col gap-2 border-t border-ink/15 py-4 text-[13px] text-ink/75 sm:flex-row sm:items-center sm:justify-between">
<p>© {{ date('Y') }} TRETA. All rights reserved.</p>
<div class="flex items-center gap-4">
<a href="/privacy" class="ft-link ft-link--small">Privacy</a>
<a href="#page-top" class="ft-top" aria-label="Back to top"><svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4 rotate-180" aria-hidden="true"><path d="M8 2.5v11M3.5 9L8 13.5 12.5 9" /></svg></a>
</div>
</div>
</div>
<div aria-hidden="true" class="relative mx-auto w-full max-w-[1440px] select-none px-6 pb-8 sm:px-8 lg:px-12">
<div data-dot-word="TRETA" class="ft-dots">
<p class="whitespace-nowrap text-center text-[clamp(4.5rem,18vw,17rem)] font-light leading-none tracking-[0.3em] text-ink">TRETA</p>
<canvas></canvas>
</div>
</div>
</footer>
