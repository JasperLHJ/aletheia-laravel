<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Blogs/Index', [
            'posts' => Post::with('user')
                ->orderByDesc('created_at')
                ->get(),
            'instagramScrapeLimitDefault' => (int) config('services.instagram.scrape_limit', 24),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Blogs/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedPost($request);
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['user_id'] = $request->user()->id;
        $validated['is_featured'] = $request->boolean('is_featured');
        $this->ensurePublishedTimestamp($validated);

        Post::create($validated);

        return Redirect::route('blogs.index')->with('success', 'Blog post created.');
    }

    public function show(Post $post): Response
    {
        $post->load('user');

        return Inertia::render('Blogs/View', [
            'post' => $post,
        ]);
    }

    public function edit(Post $post): Response
    {
        return Inertia::render('Blogs/Edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $this->validatedPost($request, $post);
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $this->ensurePublishedTimestamp($validated, $post);

        $post->update($validated);

        return Redirect::route('blogs.index')->with('success', 'Blog post updated.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return Redirect::route('blogs.index')->with('success', 'Blog post deleted.');
    }

    public function scrape(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $limit = $validated['limit'] ?? (int) config('services.instagram.scrape_limit', 24);

        $exitCode = Artisan::call('instagram:scrape', [
            '--limit' => $limit,
        ]);

        $output = trim(Artisan::output());

        if ($exitCode === 0) {
            $upserted = null;
            if (preg_match('/Done\.\s*(\d+)\s*post\(s\)\s*upserted/', $output, $m)) {
                $upserted = (int) $m[1];
            }

            $message = $upserted !== null
                ? "Instagram sync finished: {$upserted} post(s) upserted (requested up to {$limit})."
                : 'Instagram posts synced successfully.';

            if ($upserted !== null && $upserted < $limit && str_contains($output, 'Instagram feed')) {
                $message .= ' Instagram blocked loading older posts for now (rate limit). Wait a few minutes and press Sync again, or run: php artisan instagram:scrape --limit='.$limit;
            }

            return Redirect::route('blogs.index')->with('success', $message);
        }

        return Redirect::route('blogs.index')->with('error', 'Instagram sync failed. Check the logs for details.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedPost(Request $request, ?Post $post = null): array
    {
        $slugRule = ['nullable', 'string', 'max:255', 'unique:posts,slug'];
        if ($post) {
            $slugRule = ['nullable', 'string', 'max:255', 'unique:posts,slug,'.$post->id];
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => $slugRule,
            'body' => ['required', 'string'],
            'excerpt' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'string', 'max:500'],
            'reading_time_minutes' => ['nullable', 'integer', 'min:1', 'max:1440'],
            'category' => ['nullable', 'string', 'max:100'],
            'published_at' => ['nullable', 'date'],
            'status' => ['required', 'in:draft,published'],
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function ensurePublishedTimestamp(array &$data, ?Post $existing = null): void
    {
        if (($data['status'] ?? '') !== 'published') {
            return;
        }

        if (! empty($data['published_at'])) {
            return;
        }

        if ($existing?->published_at) {
            $data['published_at'] = $existing->published_at;

            return;
        }

        $data['published_at'] = now();
    }
}
