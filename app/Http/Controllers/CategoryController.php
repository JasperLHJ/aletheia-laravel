<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(): Response
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): Response
    {
        return Inertia::render('Categories/Create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        Category::create($validated);

        return Redirect::route('categories.index')->with('success', 'Category created.');
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category): Response
    {
        return Inertia::render('Categories/View', [
            'category' => $category->loadCount(['posts', 'products']),
        ]);
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): Response
    {
        return Inertia::render('Categories/Edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug,' . $category->id],
            'description' => ['nullable', 'string'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $category->update($validated);

        return Redirect::route('categories.index')->with('success', 'Category updated.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return Redirect::route('categories.index')->with('success', 'Category deleted.');
    }
}
