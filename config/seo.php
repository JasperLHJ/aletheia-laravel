<?php

return [
    'site_url' => rtrim(env('APP_URL', 'https://aletheiaresourcecenter.com'), '/'),

    'site_name' => env('SEO_SITE_NAME', env('APP_NAME', 'Aletheia Resource Center')),

    'default_title' => env('SEO_DEFAULT_TITLE', 'Aletheia Resource Center'),

    'default_description' => env(
        'SEO_DEFAULT_DESCRIPTION',
        'Aletheia Resource Center nurtures curious minds and principled leaders through rigorous academics and dedicated educators.'
    ),

    'default_image' => env('SEO_DEFAULT_IMAGE', '/images/og-default.jpg'),

    'default_image_width' => (int) env('SEO_DEFAULT_IMAGE_WIDTH', 1200),

    'default_image_height' => (int) env('SEO_DEFAULT_IMAGE_HEIGHT', 630),

    'locale' => env('SEO_LOCALE', 'en_US'),

    'twitter_handle' => env('SEO_TWITTER_HANDLE', ''),

    'theme_color' => env('SEO_THEME_COLOR', '#0f172a'),

    'organization' => [
        'name' => env('SEO_ORG_NAME', 'Aletheia Resource Center'),
        'legal_name' => env('SEO_ORG_LEGAL_NAME', 'Aletheia Resource Center'),
        'logo' => env('SEO_ORG_LOGO', '/images/aletheia-logo.svg'),
        'telephone' => env('SEO_ORG_TELEPHONE', '+60123450702'),
        'email' => env('SEO_ORG_EMAIL', 'info@aletheiaacademy.edu.my'),
        'same_as' => array_values(array_filter([
            env('SEO_ORG_FACEBOOK', 'https://www.facebook.com/AletheiaResourceCenter/'),
            env('SEO_ORG_INSTAGRAM', 'https://www.instagram.com/aletheiaresourcecenter/'),
        ])),
    ],
];
