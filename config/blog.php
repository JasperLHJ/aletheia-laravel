<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public blog listing
    |--------------------------------------------------------------------------
    |
    | Maximum number of published posts returned for the public /blog page and
    | included in the generated sitemap for individual blog post URLs. Detail
    | pages for other published posts remain reachable if linked directly.
    |
    */

    'listing_limit' => max(1, (int) env('BLOG_LISTING_LIMIT', 24)),

];
