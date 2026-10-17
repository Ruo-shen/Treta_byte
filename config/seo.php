<?php

return [

    // Default meta description when a page supplies none.
    'default_description' => 'TRETA Lab fixes what\'s broken, builds what\'s needed, and cares for what matters.',

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

];
