{{-- Footer variant for /home-next and inner pages on feat/home-next (layout picks it via @section('footer-variant')). Same links as components.footer; 12px labels and 44px targets. --}}
<footer class="on-footer-next relative overflow-hidden bg-paper">
<div class="mx-auto w-full max-w-[1300px] px-5 sm:px-8">
<div class="grid gap-12 border-t border-line pt-14 md:grid-cols-[1.47fr_1fr_1.1fr_0.85fr] md:pt-14 max-md:gap-y-1 max-md:pt-4">
<div>
<p class="text-[20px] font-medium tracking-[0.5em]">TRETA</p>
<p class="mt-9 text-[17px] leading-[1.55] text-ink/75 max-md:mt-2 max-md:text-[15px]">Technology should work for you.<br>Independent digital solutions studio.</p>
</div>
<nav aria-label="Studio">
<p class="font-mono text-[12px] font-medium uppercase tracking-[0.3em] text-ink/70 max-md:sr-only">Studio</p>
<ul class="mt-5 space-y-0 max-md:mt-0 max-md:grid max-md:space-y-0 max-md:grid-cols-3">
<li>
<a href="/services" class="inline-flex min-h-11 items-center text-[17px] text-ink/85 transition-colors hover:text-accent max-md:flex max-md:text-[15px]">Services</a>
</li>
<li>
<a href="/work" class="inline-flex min-h-11 items-center text-[17px] text-ink/85 transition-colors hover:text-accent max-md:flex max-md:text-[15px]">Work</a>
</li>
<li>
<a href="/#process" class="inline-flex min-h-11 items-center text-[17px] text-ink/85 transition-colors hover:text-accent max-md:flex max-md:text-[15px]">Process</a>
</li>
<li>
<a href="/about" class="inline-flex min-h-11 items-center text-[17px] text-ink/85 transition-colors hover:text-accent max-md:flex max-md:text-[15px]">About</a>
</li>
<li>
<a href="/contact" class="inline-flex min-h-11 items-center text-[17px] text-ink/85 transition-colors hover:text-accent max-md:flex max-md:text-[15px]">Contact</a>
</li>
<li>
<a href="/blog" class="inline-flex min-h-11 items-center text-[17px] text-ink/85 hover:text-accent max-md:flex max-md:text-[15px]">Blog</a>
</li>
</ul>
</nav>
<nav aria-label="Services">
<p class="font-mono text-[12px] font-medium uppercase tracking-[0.3em] text-ink/70 max-md:sr-only">Services</p>
<ul class="mt-5 space-y-0 max-md:mt-0 max-md:grid max-md:space-y-0 max-md:grid-cols-2">
<li>
<a href="/services/web-development" class="inline-flex min-h-11 items-center text-[17px] text-ink/85 transition-colors hover:text-accent max-md:flex max-md:text-[15px]">Web development</a>
</li>
<li>
<a href="/services/website-repair" class="inline-flex min-h-11 items-center text-[17px] text-ink/85 transition-colors hover:text-accent max-md:flex max-md:text-[15px]">Website repair</a>
</li>
<li>
<a href="/services/website-maintenance" class="inline-flex min-h-11 items-center text-[17px] text-ink/85 transition-colors hover:text-accent max-md:flex max-md:text-[15px]">Website maintenance</a>
</li>
<li>
<a href="/services/web-applications" class="inline-flex min-h-11 items-center text-[17px] text-ink/85 transition-colors hover:text-accent max-md:flex max-md:text-[15px]">Web applications</a>
</li>
</ul>
</nav>
<div>
<p class="font-mono text-[12px] font-medium uppercase tracking-[0.3em] text-ink/70 max-md:sr-only">Get in touch</p>
<a href="/contact" class="mt-5 inline-flex min-h-11 items-center text-[17px] text-ink/85 hover:text-accent max-md:hidden">Start a conversation ↗</a>
<p class="mt-[14px] text-[17px] text-muted max-md:mt-0 max-md:inline max-md:text-[15px]">Based in Nepal.</p>
<p class="mt-[14px] text-[17px] text-muted max-md:mt-0 max-md:inline max-md:text-[15px]">Working worldwide.</p>
</div>
</div>
<div class="relative z-10 mt-16 flex flex-col gap-4 pb-8 text-[13.5px] text-ink/70 sm:flex-row sm:items-center sm:justify-between md:mt-[70px] max-md:mt-0 max-md:flex-row max-md:items-center max-md:justify-between max-md:gap-2 max-md:pb-1 max-md:text-[13px]">
<p>© {{ date('Y') }} TRETA. All rights reserved.</p>
<div class="flex items-center gap-12 max-md:gap-0">
<a href="/privacy" class="max-md:inline-flex max-md:min-h-11 max-md:items-center max-md:px-3">Privacy</a>
<a href="#page-top" class="inline-flex items-center gap-2 hover:text-ink max-md:min-h-11 max-md:min-w-11 max-md:justify-center">
<span class="max-md:sr-only">Back to top</span> <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" class="h-3.5 w-3.5 rotate-180" aria-hidden="true">
<path d="M8 2.5v11M3.5 9L8 13.5 12.5 9" />
</svg>
</a>
</div>
</div>
</div>
<p aria-hidden="true" class="max-md:hidden pointer-events-none -mb-[0.32em] select-none whitespace-nowrap text-center text-[clamp(7rem,22vw,20rem)] font-light leading-none tracking-[0.4em] text-ink/[0.035]">TRETA</p>
</footer>
