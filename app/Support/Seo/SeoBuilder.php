<?php

namespace App\Support\Seo;

use App\Models\Post;
use App\Services\SiteContentRepository;
use Illuminate\Support\Str;

class SeoBuilder
{
    public function __construct(private readonly SiteContentRepository $siteContent)
    {
    }

    /**
     * Build SEO data for a named site-content page (welcome, about, gallery, contact, programmes, blog).
     *
     * @param  array<string, mixed>  $overrides
     */
    public function forPage(string $pageKey, array $overrides = []): SeoData
    {
        $page = $this->safePage($pageKey);
        $meta = is_array($page['meta'] ?? null) ? $page['meta'] : [];

        $defaults = $this->siteDefaults();
        $pathForKey = $this->pathForPageKey($pageKey);

        $data = array_merge($defaults, [
            'title' => $meta['title'] ?? $defaults['title'],
            'description' => $meta['description'] ?? $defaults['description'],
            'image' => $this->absoluteUrl($meta['image'] ?? $defaults['image']),
            'canonical' => $this->absoluteUrl($pathForKey),
            'url' => $this->absoluteUrl($pathForKey),
        ], $overrides);

        $data['jsonLd'] = array_merge($this->globalJsonLd(), $data['jsonLd'] ?? []);

        return $this->toDto($data);
    }

    /**
     * Build SEO data for an arbitrary public route (path or URL).
     *
     * @param  array<string, mixed>  $overrides
     */
    public function forRoute(string $path, array $overrides = []): SeoData
    {
        $defaults = $this->siteDefaults();

        $data = array_merge($defaults, [
            'canonical' => $this->absoluteUrl($path),
            'url' => $this->absoluteUrl($path),
            'image' => $this->absoluteUrl($overrides['image'] ?? $defaults['image']),
        ], $overrides);

        $data['jsonLd'] = array_merge($this->globalJsonLd(), $data['jsonLd'] ?? []);

        return $this->toDto($data);
    }

    /**
     * Build SEO data for a blog post detail page.
     */
    public function forPost(Post $post): SeoData
    {
        $defaults = $this->siteDefaults();
        $url = $this->absoluteUrl('/blog/'.$post->slug);
        $image = $this->absoluteUrl(
            $post->featured_image ?: ($defaults['image'] ?? '/images/og-default.jpg')
        );
        $description = $this->postDescription($post);
        $publishedAt = optional($post->published_at ?? $post->created_at)->toIso8601String();
        $modifiedAt = optional($post->updated_at ?? $post->published_at ?? $post->created_at)->toIso8601String();
        $author = optional($post->user)->name ?: $defaults['siteName'];

        $breadcrumbs = [
            ['name' => 'Home', 'url' => $this->absoluteUrl('/')],
            ['name' => 'Blog', 'url' => $this->absoluteUrl('/blog')],
            ['name' => $post->title, 'url' => $url],
        ];

        $articleLd = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => $description,
            'image' => [$image],
            'datePublished' => $publishedAt,
            'dateModified' => $modifiedAt,
            'author' => [
                '@type' => 'Person',
                'name' => $author,
            ],
            'publisher' => $this->publisherLd(),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $url,
            ],
            'articleSection' => $post->category ?: null,
            'url' => $url,
        ], static fn ($value) => $value !== null && $value !== '');

        $data = array_merge($defaults, [
            'title' => $post->title,
            'description' => $description,
            'canonical' => $url,
            'url' => $url,
            'image' => $image,
            'type' => 'article',
            'publishedAt' => $publishedAt,
            'modifiedAt' => $modifiedAt,
            'author' => $author,
            'breadcrumbs' => $breadcrumbs,
            'jsonLd' => array_merge($this->globalJsonLd(), [
                $articleLd,
                $this->breadcrumbLd($breadcrumbs),
            ]),
        ]);

        return $this->toDto($data);
    }

    /**
     * @return array<string, mixed>
     */
    public function siteDefaults(): array
    {
        $site = $this->safeSite();
        $seo = is_array($site['seo'] ?? null) ? $site['seo'] : [];

        $siteName = $seo['siteName'] ?? config('seo.site_name');
        $title = $seo['defaultTitle'] ?? config('seo.default_title', $siteName);
        $description = $seo['defaultDescription'] ?? config('seo.default_description');
        $image = $seo['defaultImage'] ?? config('seo.default_image');
        $locale = $seo['locale'] ?? config('seo.locale');
        $twitter = $seo['twitterHandle'] ?? config('seo.twitter_handle');

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $this->absoluteUrl('/'),
            'url' => $this->absoluteUrl('/'),
            'image' => $this->absoluteUrl($image),
            'imageWidth' => (int) config('seo.default_image_width', 1200),
            'imageHeight' => (int) config('seo.default_image_height', 630),
            'type' => 'website',
            'siteName' => $siteName,
            'locale' => $locale,
            'twitterCard' => 'summary_large_image',
            'twitterHandle' => $twitter,
            'themeColor' => config('seo.theme_color', '#0f172a'),
            'robots' => 'index, follow',
            'publishedAt' => null,
            'modifiedAt' => null,
            'author' => null,
            'jsonLd' => [],
            'breadcrumbs' => [],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function globalJsonLd(): array
    {
        $site = $this->safeSite();
        $seo = is_array($site['seo'] ?? null) ? $site['seo'] : [];
        $org = is_array($seo['organization'] ?? null) ? $seo['organization'] : [];

        $orgConfig = config('seo.organization', []);
        $name = $org['name'] ?? $orgConfig['name'] ?? config('seo.site_name');
        $logo = $this->absoluteUrl($org['logo'] ?? $orgConfig['logo'] ?? '/images/aletheia-logo.svg');
        $sameAs = $org['sameAs'] ?? $orgConfig['same_as'] ?? [];
        $telephone = $org['telephone'] ?? $orgConfig['telephone'] ?? null;
        $email = $org['email'] ?? $orgConfig['email'] ?? null;
        $siteUrl = $this->absoluteUrl('/');

        $organizationLd = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'EducationalOrganization',
            '@id' => $siteUrl.'#organization',
            'name' => $name,
            'url' => $siteUrl,
            'logo' => $logo,
            'sameAs' => array_values(array_filter($sameAs)),
            'telephone' => $telephone,
            'email' => $email,
        ], static fn ($value) => $value !== null && $value !== '' && $value !== []);

        $websiteLd = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => $siteUrl.'#website',
            'url' => $siteUrl,
            'name' => $name,
            'publisher' => ['@id' => $siteUrl.'#organization'],
            'inLanguage' => str_replace('_', '-', (string) config('seo.locale', 'en_US')),
        ];

        return [$organizationLd, $websiteLd];
    }

    /**
     * @param  list<array{name: string, url: string}>  $items
     * @return array<string, mixed>
     */
    public function breadcrumbLd(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_values(array_map(
                static fn (array $item, int $idx) => [
                    '@type' => 'ListItem',
                    'position' => $idx + 1,
                    'name' => $item['name'],
                    'item' => $item['url'],
                ],
                $items,
                array_keys($items),
            )),
        ];
    }

    public function absoluteUrl(?string $pathOrUrl): string
    {
        $pathOrUrl = trim((string) $pathOrUrl);

        if ($pathOrUrl === '') {
            return $this->siteUrl();
        }

        if (Str::startsWith($pathOrUrl, ['http://', 'https://'])) {
            return $pathOrUrl;
        }

        return $this->siteUrl().'/'.ltrim($pathOrUrl, '/');
    }

    public function siteUrl(): string
    {
        return rtrim((string) config('seo.site_url'), '/');
    }

    private function pathForPageKey(string $key): string
    {
        return match ($key) {
            'welcome', 'home' => '/',
            'about' => '/about',
            'gallery' => '/gallery',
            'contact' => '/contact',
            'programmes' => '/programmes',
            'blog' => '/blog',
            default => '/'.$key,
        };
    }

    private function postDescription(Post $post): string
    {
        if (! empty($post->excerpt)) {
            return Str::limit(strip_tags($post->excerpt), 160, '');
        }

        return Str::limit(trim(strip_tags((string) $post->body)), 160, '');
    }

    /**
     * @return array<string, mixed>
     */
    private function publisherLd(): array
    {
        $siteUrl = $this->absoluteUrl('/');
        $orgConfig = config('seo.organization', []);
        $siteName = config('seo.site_name');
        $logo = $this->absoluteUrl($orgConfig['logo'] ?? '/images/aletheia-logo.svg');

        return [
            '@type' => 'EducationalOrganization',
            '@id' => $siteUrl.'#organization',
            'name' => $orgConfig['name'] ?? $siteName,
            'url' => $siteUrl,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $logo,
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function safeSite(): array
    {
        try {
            return $this->siteContent->site();
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function safePage(string $pageKey): array
    {
        try {
            return $this->siteContent->page($pageKey);
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function toDto(array $data): SeoData
    {
        return new SeoData(
            title: (string) ($data['title'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            canonical: (string) ($data['canonical'] ?? ''),
            url: (string) ($data['url'] ?? ($data['canonical'] ?? '')),
            image: (string) ($data['image'] ?? ''),
            imageWidth: (int) ($data['imageWidth'] ?? 1200),
            imageHeight: (int) ($data['imageHeight'] ?? 630),
            type: (string) ($data['type'] ?? 'website'),
            siteName: (string) ($data['siteName'] ?? ''),
            locale: (string) ($data['locale'] ?? 'en_US'),
            twitterCard: (string) ($data['twitterCard'] ?? 'summary_large_image'),
            twitterHandle: (string) ($data['twitterHandle'] ?? ''),
            themeColor: (string) ($data['themeColor'] ?? '#0f172a'),
            robots: (string) ($data['robots'] ?? 'index, follow'),
            publishedAt: $data['publishedAt'] ?? null,
            modifiedAt: $data['modifiedAt'] ?? null,
            author: $data['author'] ?? null,
            jsonLd: is_array($data['jsonLd'] ?? null) ? $data['jsonLd'] : [],
            breadcrumbs: is_array($data['breadcrumbs'] ?? null) ? $data['breadcrumbs'] : [],
        );
    }
}
