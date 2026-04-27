<?php

namespace App\Console\Commands;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ScrapeInstagramCommand extends Command
{
    private const MAX_SCRAPE_LIMIT = 100;

    private const FEED_PAGE_SIZE = 12;

    protected $signature = 'instagram:scrape {--limit= : Maximum posts to sync (defaults to config services.instagram.scrape_limit)}';

    protected $description = 'Scrape recent posts from the Aletheia Instagram account and upsert into the posts table';

    public function handle(): int
    {
        $username = config('services.instagram.username', 'aletheiaresourcecenter');

        $limitOption = $this->option('limit');
        $limit = $limitOption !== null && $limitOption !== ''
            ? (int) $limitOption
            : (int) config('services.instagram.scrape_limit', 24);
        $limit = max(1, min($limit, self::MAX_SCRAPE_LIMIT));

        $this->info("Fetching Instagram posts for @{$username} (up to {$limit})...");

        $profileResponse = $this->instagramClient($username)->get('https://i.instagram.com/api/v1/users/web_profile_info/', [
            'username' => $username,
        ]);

        if (! $profileResponse->successful()) {
            $this->error("Instagram profile request failed with status {$profileResponse->status()}.");

            return self::FAILURE;
        }

        $profileJson = $profileResponse->json();
        $userId = data_get($profileJson, 'data.user.id');

        if (! $userId) {
            $this->warn('No user id in Instagram response. The endpoint may have changed or the account may be private.');

            return self::SUCCESS;
        }

        $entries = $this->collectTimelineEntries($username, (string) $userId, $profileJson, $limit);

        if ($entries === []) {
            $this->warn('No posts found in the Instagram response. The endpoint may have changed or the account may be private.');

            return self::SUCCESS;
        }

        $upserted = 0;

        foreach ($entries as $entry) {
            $shortcode = $entry['shortcode'];
            $node = $entry['node'];
            $caption = $entry['caption'];
            $timestamp = $entry['timestamp'];

            if (! $shortcode) {
                continue;
            }

            [$mediaType, $thumbnailUrl, $videoUrl] = $this->resolveMedia($node);

            $title = $caption
                ? Str::limit(strtok($caption, "\n"), 100, '')
                : "Instagram post {$shortcode}";

            Post::updateOrCreate(
                ['external_id' => $shortcode],
                [
                    'title' => $title,
                    'slug' => "instagram-{$shortcode}",
                    'body' => $caption ?: '',
                    'excerpt' => $caption ? Str::limit($caption, 200) : null,
                    'featured_image' => $thumbnailUrl,
                    'video_url' => $videoUrl,
                    'media_type' => $mediaType,
                    'published_at' => $timestamp ? Carbon::createFromTimestamp($timestamp) : now(),
                    'status' => 'published',
                    'category' => 'Instagram',
                    'source' => 'instagram',
                    'source_url' => "https://www.instagram.com/p/{$shortcode}/",
                    'user_id' => null,
                ]
            );

            $upserted++;
        }

        $this->info("Done. {$upserted} post(s) upserted (requested limit: {$limit}).");

        return self::SUCCESS;
    }

    /**
     * @return array<int, array{shortcode: string|null, node: array<string, mixed>, caption: string, timestamp: int|null}>
     */
    private function collectTimelineEntries(string $username, string $userId, array $profileJson, int $limit): array
    {
        /** @var array<string, array{shortcode: string|null, node: array<string, mixed>, caption: string, timestamp: int|null}> $byCode */
        $byCode = [];

        $edges = data_get($profileJson, 'data.user.edge_owner_to_timeline_media.edges', []);

        foreach ($edges as $edge) {
            $node = $edge['node'] ?? [];
            $shortcode = $node['shortcode'] ?? null;
            if (! $shortcode || isset($byCode[$shortcode])) {
                continue;
            }
            $caption = (string) data_get($node, 'edge_media_to_caption.edges.0.node.text', '');
            $ts = isset($node['taken_at_timestamp']) ? (int) $node['taken_at_timestamp'] : null;
            $byCode[$shortcode] = [
                'shortcode' => $shortcode,
                'node' => $node,
                'caption' => $caption,
                'timestamp' => $ts,
            ];
            if (count($byCode) >= $limit) {
                return array_values($byCode);
            }
        }

        $lastNode = ($edges !== [] && isset($edges[count($edges) - 1]['node'])) ? $edges[count($edges) - 1]['node'] : null;
        $lastMediaId = $lastNode['id'] ?? null;
        $maxId = ($lastMediaId !== null && $lastMediaId !== '') ? "{$lastMediaId}_{$userId}" : null;

        if (count($byCode) >= $limit || $maxId === null) {
            return array_values($byCode);
        }

        $client = $this->instagramClient($username);
        $firstPageThreshold = min(self::FEED_PAGE_SIZE, $limit);

        $this->info('Collecting the rest from the user feed in two API rounds where possible: first ~'.self::FEED_PAGE_SIZE.' post(s) per request, a short pause, then the next page toward your limit.');

        $pausedBetweenBatches = false;

        while (count($byCode) < $limit) {
            if ($maxId === null) {
                break;
            }

            if (
                ! $pausedBetweenBatches
                && count($byCode) >= $firstPageThreshold
                && count($byCode) < $limit
            ) {
                $this->info('Instagram timeline batch 1/2: at least '.$this->friendlyCount($byCode).' post(s) collected; pausing before batch 2 (older posts / next page).');
                sleep(2);
                $this->info('Instagram timeline batch 2/2: resuming the user feed (second scrape pass).');
                $pausedBetweenBatches = true;
            }

            $count = min(self::FEED_PAGE_SIZE, $limit - count($byCode));
            $query = array_filter([
                'count' => $count,
                'max_id' => $maxId,
            ], fn ($v) => $v !== null && $v !== '');

            $feedResponse = $client->get("https://i.instagram.com/api/v1/feed/user/{$userId}/", $query);

            if (! $feedResponse->successful()) {
                $this->warn("Instagram feed request failed with status {$feedResponse->status()}; using {$this->friendlyCount($byCode)} post(s) from the profile page.");
                break;
            }

            $payload = $feedResponse->json();
            if (($payload['status'] ?? '') !== 'ok') {
                $msg = (string) ($payload['message'] ?? 'Unknown error');
                $this->warn("Instagram feed returned non-ok status ({$msg}); using {$this->friendlyCount($byCode)} post(s) collected so far.");
                break;
            }

            $items = $payload['items'] ?? [];

            foreach ($items as $item) {
                if (! is_array($item)) {
                    continue;
                }
                $shortcode = $item['code'] ?? null;
                if (! $shortcode || isset($byCode[$shortcode])) {
                    continue;
                }
                $node = $this->feedItemToGraphNode($item);
                $caption = (string) data_get($item, 'caption.text', '');
                $ts = isset($item['taken_at']) ? (int) $item['taken_at'] : null;
                $byCode[$shortcode] = [
                    'shortcode' => $shortcode,
                    'node' => $node,
                    'caption' => $caption,
                    'timestamp' => $ts,
                ];
                if (count($byCode) >= $limit) {
                    return array_values($byCode);
                }
            }

            if (empty($payload['more_available']) || empty($payload['next_max_id'])) {
                break;
            }

            $maxId = (string) $payload['next_max_id'];
        }

        return array_values($byCode);
    }

    /**
     * @param  array<string, array{shortcode: string|null, node: array<string, mixed>, caption: string, timestamp: int|null}>  $byCode
     */
    private function friendlyCount(array $byCode): int
    {
        return count($byCode);
    }

    private function instagramClient(string $username): \Illuminate\Http\Client\PendingRequest
    {
        return Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
            'Accept' => '*/*',
            'Accept-Language' => 'en-US,en;q=0.9',
            'x-ig-app-id' => '936619743392459',
            'Referer' => "https://www.instagram.com/{$username}/",
        ])->timeout(30);
    }

    /**
     * Map a feed API item to a GraphQL-shaped node for resolveMedia().
     *
     * @param  array<string, mixed>  $item
     * @return array<string, mixed>
     */
    private function feedItemToGraphNode(array $item): array
    {
        $mediaType = (int) data_get($item, 'media_type', 1);

        if ($mediaType === 8) {
            $carousel = $item['carousel_media'] ?? [];
            $edges = [];
            foreach ($carousel as $child) {
                if (is_array($child)) {
                    $edges[] = ['node' => $this->feedCarouselChildToGraphNode($child)];
                }
            }

            return [
                '__typename' => 'GraphSidecar',
                'edge_sidecar_to_children' => ['edges' => $edges],
            ];
        }

        return $this->feedCarouselChildToGraphNode($item);
    }

    /**
     * @param  array<string, mixed>  $item
     * @return array<string, mixed>
     */
    private function feedCarouselChildToGraphNode(array $item): array
    {
        $mediaType = (int) data_get($item, 'media_type', 1);
        $isVideo = $mediaType === 2;

        $displayUrl = data_get($item, 'image_versions2.candidates.0.url');

        $videoUrl = $isVideo ? data_get($item, 'video_versions.0.url') : null;

        return [
            '__typename' => $isVideo ? 'GraphVideo' : 'GraphImage',
            'is_video' => $isVideo,
            'display_url' => $displayUrl,
            'video_url' => $videoUrl,
        ];
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
     * @return array{string, string|null, string|null} [mediaType, thumbnailUrl, videoUrl]
     */
    private function resolveMedia(array $node): array
    {
        $typename = $node['__typename'] ?? '';

        if ($typename === 'GraphSidecar') {
            $firstChild = data_get($node, 'edge_sidecar_to_children.edges.0.node', []);

            return $this->resolveMedia(is_array($firstChild) ? $firstChild : []);
        }

        $isVideo = ! empty($node['is_video']);
        $thumbnailUrl = $node['display_url'] ?? null;
        $videoUrl = $isVideo ? ($node['video_url'] ?? null) : null;
        $mediaType = $isVideo ? 'video' : 'image';

        return [$mediaType, $thumbnailUrl, $videoUrl];
    }
}
