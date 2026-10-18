<?php

return [

    // Default meta description when a page supplies none (same text as the layout's fallback).
    'default_description' => 'A technology solutions studio. We fix what is broken, build what is needed, and care for what matters.',

    // Approved page titles (mirrors the approved copy in the frontend preview router).
    'titles' => [
        'home' => 'TRETA Lab — Fix. Build. Care.',
        'services' => 'Services — TRETA Lab',
        'work' => 'Selected work — TRETA Lab',
        'about' => 'About the studio — TRETA Lab',
        'contact' => 'Start a conversation — TRETA Lab',
        'blog' => 'The journal — TRETA Lab',
        'privacy' => 'Privacy information — TRETA Lab',
        'not_found' => 'Page not found — TRETA Lab',
    ],

    // Static routes listed in sitemap.xml. Add a route only once its page content is complete and approved
    // (privacy is excluded until its content is approved).
    'sitemap_static_routes' => [
        'home',
        'services.index',
        'work.index',
        'about',
        'contact.show',
        'blog.index',
    ],

    // Analytics / Search Console. Leave both empty until the IDs AND the privacy/consent treatment are
    // approved (open launch decision). GA4 renders only in production, never on admin or preview pages.
    'ga4_measurement_id' => env('GA4_MEASUREMENT_ID'),
    'google_site_verification' => env('GOOGLE_SITE_VERIFICATION'),

];
