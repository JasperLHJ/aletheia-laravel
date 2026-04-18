<?php

namespace App\Support\Seo;

use Illuminate\Contracts\Support\Arrayable;

class SeoData implements Arrayable
{
    public function __construct(
        public string $title,
        public string $description,
        public string $canonical,
        public string $url,
        public string $image,
        public int $imageWidth = 1200,
        public int $imageHeight = 630,
        public string $type = 'website',
        public string $siteName = '',
        public string $locale = 'en_US',
        public string $twitterCard = 'summary_large_image',
        public string $twitterHandle = '',
        public string $themeColor = '#0f172a',
        public string $robots = 'index, follow',
        public ?string $publishedAt = null,
        public ?string $modifiedAt = null,
        public ?string $author = null,
        public array $jsonLd = [],
        public array $breadcrumbs = [],
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'canonical' => $this->canonical,
            'url' => $this->url,
            'image' => $this->image,
            'imageWidth' => $this->imageWidth,
            'imageHeight' => $this->imageHeight,
            'type' => $this->type,
            'siteName' => $this->siteName,
            'locale' => $this->locale,
            'twitterCard' => $this->twitterCard,
            'twitterHandle' => $this->twitterHandle,
            'themeColor' => $this->themeColor,
            'robots' => $this->robots,
            'publishedAt' => $this->publishedAt,
            'modifiedAt' => $this->modifiedAt,
            'author' => $this->author,
            'jsonLd' => $this->jsonLd,
            'breadcrumbs' => $this->breadcrumbs,
        ];
    }
}
