<?php

/*
|--------------------------------------------------------------------------
| Approved case studies (frontend-owned content definitions)
|--------------------------------------------------------------------------
|
| Keyed by URL slug. An entry is public only when 'enabled' is true, which
| requires confirmed publication permission and content. Each enabled entry
| renders through resources/views/pages/work/case-study.blade.php.
|
| Shape:
|   'example-slug' => [
|       'enabled' => false,
|       'title' => '...',
|       'summary' => '...',
|       'seo_title' => '...',
|       'meta_description' => '...',
|       'service' => 'web-development',   // optional related service slug
|       'image' => 'images/work/x.webp', 'image_alt' => '...', 'image_caption' => '...', // optional cover
|       'image_width' => 1600, 'image_height' => 1000,   // optional; read from the file when omitted
|       'gallery' => [['image' => 'images/work/y.webp', 'alt' => '...', 'caption' => '...']], // optional
|       'facts' => ['Client' => '...'],    // optional label => value
|       'chapters' => [['id' => 'problem', 'title' => '...', 'paragraphs' => ['...'], 'points' => ['...']]],
|       'outcomes' => ['...'],             // optional
|   ],
|
*/

return [
];
