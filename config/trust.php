<?php

/*
 * Trust content. Leave every list empty until real, approved material exists; nothing renders in production while empty
 * (x-inner.trust shows placeholders only when APP_ENV=local). Never add invented clients, quotes or results.
 *
 * testimonials: ['quote' => '', 'name' => '', 'role' => '', 'company' => '']
 * logos:        ['name' => '', 'src' => '/images/clients/x.svg', 'width' => 120, 'height' => 40, 'href' => null]
 * projects:     ['title' => '', 'summary' => '', 'href' => '/work/slug']
 */
return [
    'testimonials' => [],
    'logos' => [],
    'projects' => [],
];
