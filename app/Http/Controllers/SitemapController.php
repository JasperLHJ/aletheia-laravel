<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\Seo\SeoBuilder;
use Illuminate\Http\Response as HttpResponse;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index(SeoBuilder $seo): HttpResponse
    {
        $cachedPath = public_path('sitemap.xml');

        if (is_file($cachedPath)) {
            return response()->file($cachedPath, [
                'Content-Type' => 'application/xml',
            ]);
        }

        $sitemap = $this->build($seo);

        return response($sitemap->render(), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    public function build(SeoBuilder $seo): Sitemap
    {
        $sitemap = Sitemap::create();

        $staticRoutes = [
            ['/',           Url::CHANGE_FREQUENCY_WEEKLY,  1.0],
            ['/about',      Url::CHANGE_FREQUENCY_MONTHLY, 0.8],
            ['/programmes', Url::CHANGE_FREQUENCY_MONTHLY, 0.8],
            ['/gallery',    Url::CHANGE_FREQUENCY_MONTHLY, 0.6],
            ['/contact',    Url::CHANGE_FREQUENCY_YEARLY,  0.5],
            ['/blog',       Url::CHANGE_FREQUENCY_WEEKLY,  0.8],
        ];

        foreach ($staticRoutes as [$path, $freq, $priority]) {
            $sitemap->add(
                Url::create($seo->absoluteUrl($path))
                    ->setChangeFrequency($freq)
                    ->setPriority($priority)
                    ->setLastModificationDate(now())
            );
        }

        $postLimit = (int) config('blog.listing_limit', 24);

        Post::published()
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit($postLimit)
            ->get()
            ->each(function (Post $post) use ($sitemap, $seo) {
                $lastMod = $post->updated_at ?? $post->published_at ?? $post->created_at ?? now();

                $sitemap->add(
                    Url::create($seo->absoluteUrl('/blog/'.$post->slug))
                        ->setLastModificationDate($lastMod)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.7)
                );
            });

        return $sitemap;
    }
}
