{{-- Long-form article/legal text wrapper (typography comes from .article-content). Sanitized HTML only. --}}
<div {{ $attributes->class('article-content mx-auto max-w-[760px] px-5 py-12 sm:px-8 sm:py-16') }}>{{ $slot }}</div>
