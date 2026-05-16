<!DOCTYPE html>
@php
    /** @var array<string, mixed>|null $seo */
    $seoDefaults = app(\App\Support\Seo\SeoBuilder::class)->siteDefaults();
    $seo = is_array($seo ?? null) ? array_merge($seoDefaults, $seo) : $seoDefaults;
    if (empty($seo['jsonLd'])) {
        $seo['jsonLd'] = app(\App\Support\Seo\SeoBuilder::class)->globalJsonLd();
    }
    $seoTitle = trim((string) ($seo['title'] ?? ''));
    $appName = config('app.name', 'Laravel');
    $fullTitle = $seoTitle !== '' ? $seoTitle.' - '.$appName : $appName;
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ $fullTitle }}</title>

        <meta name="description" content="{{ $seo['description'] ?? '' }}">
        <meta name="robots" content="{{ $seo['robots'] ?? 'index, follow' }}">
        <meta name="theme-color" content="{{ $seo['themeColor'] ?? '#0f172a' }}">
        <link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">

        {{-- Open Graph --}}
        <meta property="og:type" content="{{ $seo['type'] ?? 'website' }}">
        <meta property="og:site_name" content="{{ $seo['siteName'] ?? $appName }}">
        <meta property="og:title" content="{{ $seoTitle !== '' ? $seoTitle : $appName }}">
        <meta property="og:description" content="{{ $seo['description'] ?? '' }}">
        <meta property="og:url" content="{{ $seo['url'] ?? ($seo['canonical'] ?? url()->current()) }}">
        <meta property="og:locale" content="{{ $seo['locale'] ?? 'en_US' }}">
        @if(! empty($seo['image']))
            <meta property="og:image" content="{{ $seo['image'] }}">
            <meta property="og:image:width" content="{{ $seo['imageWidth'] ?? 1200 }}">
            <meta property="og:image:height" content="{{ $seo['imageHeight'] ?? 630 }}">
            <meta property="og:image:alt" content="{{ $seoTitle !== '' ? $seoTitle : ($seo['siteName'] ?? $appName) }}">
        @endif
        @if(($seo['type'] ?? '') === 'article')
            @if(! empty($seo['publishedAt']))
                <meta property="article:published_time" content="{{ $seo['publishedAt'] }}">
            @endif
            @if(! empty($seo['modifiedAt']))
                <meta property="article:modified_time" content="{{ $seo['modifiedAt'] }}">
            @endif
            @if(! empty($seo['author']))
                <meta property="article:author" content="{{ $seo['author'] }}">
            @endif
        @endif

        {{-- Twitter --}}
        <meta name="twitter:card" content="{{ $seo['twitterCard'] ?? 'summary_large_image' }}">
        @if(! empty($seo['twitterHandle']))
            <meta name="twitter:site" content="{{ $seo['twitterHandle'] }}">
            <meta name="twitter:creator" content="{{ $seo['twitterHandle'] }}">
        @endif
        <meta name="twitter:title" content="{{ $seoTitle !== '' ? $seoTitle : $appName }}">
        <meta name="twitter:description" content="{{ $seo['description'] ?? '' }}">
        @if(! empty($seo['image']))
            <meta name="twitter:image" content="{{ $seo['image'] }}">
        @endif

        {{-- Favicons & PWA --}}
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" sizes="any">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

        {{-- Structured data (JSON-LD) --}}
        @foreach((array) ($seo['jsonLd'] ?? []) as $ldItem)
            @if(! empty($ldItem))
                <script type="application/ld+json">{!! json_encode($ldItem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
            @endif
        @endforeach

        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-861FQ1KFKY"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-861FQ1KFKY');
        </script>

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="h-full font-sans antialiased">
        @inertia
    </body>
</html>
