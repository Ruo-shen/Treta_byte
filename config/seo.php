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

    // Unique meta descriptions, each taken from approved copy already on that page (no new claims).
    'descriptions' => [
        'home' => 'We came together to fix what’s broken, build what’s needed, and care for what matters. You talk directly to the people doing the work.',
        'services' => 'A one-off repair, a new website, or someone to keep things running. Start with the problem; we’ll work out the right next step together.',
        'work' => 'Project stories should show what actually happened: the problem, the work, and what changed. We publish them with the people involved.',
        'about' => 'We started TRETA Lab around a simple idea: technology should work for the people who depend on it.',
        'contact' => 'A broken website, an idea for something new, or a system that needs care. You don’t need a technical brief to get started.',
        'blog' => 'Notes on websites, systems, and the practical work of keeping technology useful.',
        'privacy' => 'This page is being prepared alongside the inquiry service. Final storage, retention, email delivery, and contact details must be confirmed before launch.',
        'not_found' => 'The link may have changed, or the address might have a typo. Let’s get you back to something useful.',
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
