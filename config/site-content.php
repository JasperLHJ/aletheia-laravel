<?php

return [
    'path' => resource_path('data/site-content'),

    /*
    | Whitelisted CMS documents (slug => admin label). Only these keys may be read/written.
    | Slug "site" maps to site.json; all others map to {slug}.json in path.
    */
    'documents' => [
        'site' => 'Site-wide (nav, footer, brand, SEO defaults)',
        'welcome' => 'Home page',
        'about' => 'About page',
        'gallery' => 'Gallery page',
        'contact' => 'Contact page',
        'programmes' => 'Programmes page',
        'blog' => 'Blog page (hero & copy)',
    ],

    /*
    | Public URL for each document (used to link editors to the live page).
    | null means the document affects multiple pages or has no single URL.
    */
    'document_urls' => [
        'site'       => null,
        'welcome'    => '/',
        'about'      => '/about',
        'gallery'    => '/gallery',
        'contact'    => '/contact',
        'programmes' => '/programmes',
        'blog'       => '/blog',
    ],
];
