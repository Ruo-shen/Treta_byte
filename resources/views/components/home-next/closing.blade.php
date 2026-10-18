@php
    $steps = [
        ['Talk it through', 'The goal, what you already have, and what’s getting in the way.'],
        ['Agree the scope', 'You should understand the proposed work and its boundaries.'],
        ['Know the next step', 'A clear next step, understood before the work starts.'],
    ];
@endphp
<section class="bg-paper pb-10 pt-4 sm:pb-12 sm:pt-8">
    <div class="mx-auto w-full max-w-[1260px] px-5 sm:px-8">
        <div class="on-dark relative overflow-hidden rounded-[16px] bg-dark text-white">
            <div class="relative grid gap-10 px-6 py-12 sm:px-14 sm:py-16 lg:grid-cols-[1.1fr_0.9fr] lg:gap-16 lg:px-20">
                <div class="min-w-0">
                    <x-inner.kicker dark>Start a conversation</x-inner.kicker>
                    <h2 class="hn-h2 mt-6">Have something that needs<br><span class="text-sage">fixing or building?</span></h2>
                    <p class="mt-6 max-w-[480px] text-[17px] leading-[1.55] text-white/75">Tell us what's going on. We'll reply with honest next steps — even if that means pointing you elsewhere.</p>
                    <div class="mt-8 flex flex-wrap items-center gap-x-8 gap-y-4">
                        <x-inner.button :href="route('contact.show')" variant="accent">Tell us what you need</x-inner.button>
                        <a href="#process" class="inline-flex min-h-11 items-center border-b border-white/30 text-[15px] text-white/85 hover:border-white hover:text-white">Read how we work first</a>
                    </div>
                </div>
                <div class="min-w-0 lg:pt-2">
                    <p class="font-mono text-[12px] uppercase tracking-[0.2em] text-white/70">Before we begin</p>
                    <ol class="mt-5 border-t border-white/15">
                        @foreach($steps as [$title, $text])
                            <li class="grid grid-cols-[32px_1fr] gap-x-3 border-b border-white/15 py-4">
                                <span class="pt-1 font-mono text-[12px] text-sage">0{{ $loop->iteration }}</span>
                                <div>
                                    <p class="text-[18px] font-medium tracking-[-0.01em]">{{ $title }}</p>
                                    <p class="mt-1 text-[15px] leading-[1.5] text-white/70">{{ $text }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
        <x-inner.placeholder class="mt-5" what="contact details: public email, phone or WhatsApp, working hours (owner to supply, approved)" />
    </div>
</section>
