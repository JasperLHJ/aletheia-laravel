<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\SiteContentRepository;
use App\Support\Seo\SeoBuilder;
use Inertia\Inertia;
use Inertia\Response;

class PublicBlogController extends Controller
{
    private const FALLBACK_IMAGE = '/images/class-2.jpg';

    public function index(SiteContentRepository $siteContent, SeoBuilder $seo): Response
    {
        $limit = (int) config('blog.listing_limit', 24);

        $rows = Post::published()
            ->with('user')
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();

        $posts = $rows->map(fn (Post $post) => $this->toPublicCard($post))->values()->all();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => $seo->absoluteUrl('/')],
            ['name' => 'Blog', 'url' => $seo->absoluteUrl('/blog')],
        ];

        $itemListLd = [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'itemListElement' => $rows->values()->map(fn (Post $post, int $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'url' => $seo->absoluteUrl('/blog/'.$post->slug),
                'name' => $post->title,
            ])->all(),
        ];

        $blogSeo = $seo->forPage('blog', [
            'jsonLd' => [$itemListLd, $seo->breadcrumbLd($breadcrumbs)],
            'breadcrumbs' => $breadcrumbs,
        ]);

        return Inertia::render('Blog', [
            'posts' => $posts,
            'pageContent' => $siteContent->page('blog'),
        ])->withViewData('seo', $blogSeo->toArray());
    }

    public function show(string $slug, SeoBuilder $seo): Response
    {
        $post = Post::published()
            ->with('user')
            ->where('slug', $slug)
            ->firstOrFail();

        $sameCategory = Post::published()
            ->where('id', '!=', $post->id)
            ->when($post->category, fn ($query) => $query->where('category', $post->category))
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        $ids = $sameCategory->pluck('id')->all();

        $merged = $sameCategory;

        if ($sameCategory->count() < 3) {
            $more = Post::published()
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $ids)
                ->orderByDesc('published_at')
                ->orderByDesc('created_at')
                ->limit(3 - $sameCategory->count())
                ->get();

            $merged = $sameCategory->concat($more);
        }

        $relatedPosts = $merged
            ->take(3)
            ->map(fn (Post $p) => $this->toPublicCard($p))
            ->values()
            ->all();

        return Inertia::render('BlogShow', [
            'post' => $this->toPublicArticle($post),
            'relatedPosts' => $relatedPosts,
        ])->withViewData('seo', $seo->forPost($post)->toArray());
    }

    /**
     * @return array<string, mixed>
     */
    private function toPublicCard(Post $post): array
    {
        $date = $post->published_at ?? $post->created_at;

        return [
            'slug' => $post->slug,
            'category' => $post->category ?? '',
            'title' => $post->title,
            'excerpt' => $post->excerpt ?? '',
            'date' => $date?->toIso8601String() ?? '',
            'updatedAt' => optional($post->updated_at)->toIso8601String() ?? '',
            'image' => $post->featured_image ?: self::FALLBACK_IMAGE,
            'videoUrl' => $post->video_url,
            'mediaType' => $post->media_type ?? 'image',
            'sourceUrl' => $post->source_url,
            'readingTime' => $this->readingTimeMinutes($post),
            'featured' => (bool) $post->is_featured,
            'author' => $post->user?->name ?? 'Aletheia Resource Center',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function toPublicArticle(Post $post): array
    {
        return array_merge($this->toPublicCard($post), [
            'body' => $post->body,
        ]);
    }

    private function readingTimeMinutes(Post $post): int
    {
        if ($post->reading_time_minutes) {
            return max(1, (int) $post->reading_time_minutes);
        }

        $words = str_word_count(strip_tags($post->body));

        return max(1, (int) ceil($words / 200));
    }
}
