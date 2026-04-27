<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ScrapeInstagramCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_instagram_scrape_upserts_24_posts_from_profile_and_paginated_feed(): void
    {
        config(['services.instagram.username' => 'aletheiaresourcecenter']);

        $userId = '123456';
        $edges = [];
        for ($i = 1; $i <= 12; $i++) {
            $id = (string) $i;
            $edges[] = [
                'node' => $this->profileEdgeNode("sc{$i}", $id, "Caption {$i}"),
            ];
        }
        $profileBody = [
            'data' => [
                'user' => [
                    'id' => $userId,
                    'edge_owner_to_timeline_media' => [
                        'edges' => $edges,
                    ],
                ],
            ],
        ];

        $feed1Items = [];
        for ($i = 13; $i <= 24; $i++) {
            $feed1Items[] = $this->feedItem("sc{$i}", "Body {$i}");
        }

        Http::fake([
            'i.instagram.com/api/v1/users/web_profile_info*' => Http::response($profileBody, 200),
            'i.instagram.com/api/v1/feed/user/*' => function ($request) use ($userId, $feed1Items) {
                $this->assertStringContainsString("/feed/user/{$userId}/", (string) $request->url());

                return Http::response([
                    'status' => 'ok',
                    'items' => $feed1Items,
                    'more_available' => false,
                    'next_max_id' => null,
                ], 200);
            },
        ]);

        $exit = Artisan::call('instagram:scrape', ['--limit' => 24]);

        $this->assertSame(0, $exit);
        $this->assertSame(24, Post::query()->count());
        $this->assertSame(24, Post::query()->where('source', 'instagram')->count());
        $this->assertSame(24, Post::query()->whereNotNull('external_id')->count());
    }

    /**
     * @return array<string, mixed>
     */
    private function profileEdgeNode(string $shortcode, string $id, string $caption): array
    {
        return [
            'id' => $id,
            'shortcode' => $shortcode,
            'taken_at_timestamp' => 1_700_000_000,
            '__typename' => 'GraphImage',
            'is_video' => false,
            'display_url' => 'https://example.com/'.$shortcode.'.jpg',
            'edge_media_to_caption' => [
                'edges' => [
                    ['node' => ['text' => $caption]],
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function feedItem(string $code, string $captionText): array
    {
        return [
            'code' => $code,
            'media_type' => 1,
            'taken_at' => 1_700_000_000,
            'caption' => ['text' => $captionText],
            'image_versions2' => [
                'candidates' => [
                    ['url' => 'https://example.com/f/'.$code.'.jpg'],
                ],
            ],
        ];
    }
}
