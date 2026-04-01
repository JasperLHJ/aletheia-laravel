<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index(): Response
    {
        return Inertia::render('Posts/Index', [
            'posts' => Post::with(['category', 'user'])
                ->orderByDesc('created_at')
                ->get(),
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
    }

    /**
     * Show the form for creating a new post.
     */
    public function create(): Response
    {
        return Inertia::render('Posts/Create', [
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
    }

    /**
     * Store a newly created post.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug'],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['user_id'] = $request->user()->id;

        Post::create($validated);

        return Redirect::route('posts.index')->with('success', 'Post created.');
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post): Response
    {
        $post->load(['category', 'user']);

        return Inertia::render('Posts/View', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post): Response
    {
        return Inertia::render('Posts/Edit', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
    }

    /**
     * Update the specified post.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug,' . $post->id],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        $post->update($validated);

        return Redirect::route('posts.index')->with('success', 'Post updated.');
    }

    /**
     * Remove the specified post.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return Redirect::route('posts.index')->with('success', 'Post deleted.');
    }
}
