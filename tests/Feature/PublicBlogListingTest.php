<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class PublicBlogListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_blog_listing_respects_listing_limit(): void
    {
        Post::factory()
            ->count(30)
            ->create([
                'status' => 'published',
                'user_id' => null,
            ]);

        $this->get('/blog')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Blog')
                ->has('posts', 24)
            );
    }
}
