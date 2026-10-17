<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | TRETA Lab service pages (frontend-owned content definitions)
    |--------------------------------------------------------------------------
    |
    | Keyed by URL slug; only these slugs resolve under /services/{slug}.
    | Copy fields stay null until approved copy is supplied. A page enters
    | the sitemap only once its seo_title and meta_description are set.
    |
    */

    'offerings' => [
        'web-development' => [
            'pillar' => 'build',
            'name' => 'Web development',
            'summary' => null,
            'seo_title' => null,
            'meta_description' => null,
            'problems' => [],
            'deliverables' => [],
        ],
        'website-repair' => [
            'pillar' => 'fix',
            'name' => 'Website repair',
            'summary' => null,
            'seo_title' => null,
            'meta_description' => null,
            'problems' => [],
            'deliverables' => [],
        ],
        'website-maintenance' => [
            'pillar' => 'care',
            'name' => 'Website maintenance',
            'summary' => null,
            'seo_title' => null,
            'meta_description' => null,
            'problems' => [],
            'deliverables' => [],
        ],
        'web-applications' => [
            'pillar' => 'build',
            'name' => 'Web applications',
            'summary' => null,
            'seo_title' => null,
            'meta_description' => null,
            'problems' => [],
            'deliverables' => [],
        ],
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
