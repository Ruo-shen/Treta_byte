{{-- Long-form article/legal text wrapper (typography comes from .article-content). Sanitized HTML only. --}}
<div {{ $attributes->class('article-content mx-auto max-w-[800px] px-5 py-14 sm:px-8 sm:py-20') }}>{{ $slot }}</div>
