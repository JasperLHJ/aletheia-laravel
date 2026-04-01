<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(): Response
    {
        return Inertia::render('Products/Index', [
            'products' => Product::with('category')
                ->orderBy('name')
                ->get(),
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): Response
    {
        return Inertia::render('Products/Create', [
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        Product::create($validated);

        return Redirect::route('products.index')->with('success', 'Product created.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): Response
    {
        $product->load('category');

        return Inertia::render('Products/View', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): Response
    {
        return Inertia::render('Products/Edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku,' . $product->id],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $product->update($validated);

        return Redirect::route('products.index')->with('success', 'Product updated.');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return Redirect::route('products.index')->with('success', 'Product deleted.');
    }
}
