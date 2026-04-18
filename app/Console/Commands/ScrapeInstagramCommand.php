<?php

namespace App\Console\Commands;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ScrapeInstagramCommand extends Command
{
    protected $signature = 'instagram:scrape';

    protected $description = 'Scrape recent posts from the Aletheia Instagram account and upsert into the posts table';

    public function handle(): int
    {
        $username = config('services.instagram.username', 'aletheiaresourcecenter');

        $this->info("Fetching Instagram posts for @{$username}...");

        $response = Http::withHeaders([
            'User-Agent'      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
            'Accept'          => '*/*',
            'Accept-Language' => 'en-US,en;q=0.9',
            'x-ig-app-id'     => '936619743392459',
            'Referer'         => "https://www.instagram.com/{$username}/",
        ])->timeout(30)->get('https://i.instagram.com/api/v1/users/web_profile_info/', [
            'username' => $username,
        ]);

        if (! $response->successful()) {
            $this->error("Instagram request failed with status {$response->status()}.");
            return self::FAILURE;
        }

        $edges = data_get($response->json(), 'data.user.edge_owner_to_timeline_media.edges', []);

        if (empty($edges)) {
            $this->warn('No posts found in the Instagram response. The endpoint may have changed or the account may be private.');
            return self::SUCCESS;
        }

        $upserted = 0;

        foreach ($edges as $edge) {
            $node = $edge['node'] ?? [];
            $shortcode = $node['shortcode'] ?? null;

            if (! $shortcode) {
                continue;
            }

            $caption   = data_get($node, 'edge_media_to_caption.edges.0.node.text', '');
            $timestamp = $node['taken_at_timestamp'] ?? null;

            [$mediaType, $thumbnailUrl, $videoUrl] = $this->resolveMedia($node);

            $title = $caption
                ? Str::limit(strtok($caption, "\n"), 100, '')
                : "Instagram post {$shortcode}";

            Post::updateOrCreate(
                ['external_id' => $shortcode],
                [
                    'title'          => $title,
                    'slug'           => "instagram-{$shortcode}",
                    'body'           => $caption ?: '',
                    'excerpt'        => $caption ? Str::limit($caption, 200) : null,
                    'featured_image' => $thumbnailUrl,
                    'video_url'      => $videoUrl,
                    'media_type'     => $mediaType,
                    'published_at'   => $timestamp ? Carbon::createFromTimestamp($timestamp) : now(),
                    'status'         => 'published',
                    'category'       => 'Instagram',
                    'source'         => 'instagram',
                    'source_url'     => "https://www.instagram.com/p/{$shortcode}/",
                    'user_id'        => null,
                ]
            );

            $upserted++;
        }

        $this->info("Done. {$upserted} post(s) upserted.");

        return self::SUCCESS;
    }

    /**
     * Resolve media type, thumbnail URL, and video URL from an Instagram node.
     *
     * Handles three node types:
     *   - GraphImage   (is_video = false)
     *   - GraphVideo   (is_video = true)
     *   - GraphSidecar (carousel — inspect first child)
     *
     * @param  array<string, mixed>  $node
     * @return array{string, string|null, string|null}  [mediaType, thumbnailUrl, videoUrl]
     */
    private function resolveMedia(array $node): array
    {
        $typename = $node['__typename'] ?? '';

        if ($typename === 'GraphSidecar') {
            $firstChild = data_get($node, 'edge_sidecar_to_children.edges.0.node', []);
            return $this->resolveMedia($firstChild);
        }

        $isVideo     = ! empty($node['is_video']);
        $thumbnailUrl = $node['display_url'] ?? null;
        $videoUrl     = $isVideo ? ($node['video_url'] ?? null) : null;
        $mediaType    = $isVideo ? 'video' : 'image';

        return [$mediaType, $thumbnailUrl, $videoUrl];
    }
}
