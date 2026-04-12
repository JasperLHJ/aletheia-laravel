<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TestimonialController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Testimonials/Index', [
            'testimonials' => Testimonial::query()
                ->ordered()
                ->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Testimonials/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedTestimonial($request);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Testimonial::create($validated);

        return Redirect::route('testimonials.index')->with('success', 'Testimonial created.');
    }

    public function show(Testimonial $testimonial): Response
    {
        return Inertia::render('Testimonials/View', [
            'testimonial' => $testimonial,
        ]);
    }

    public function edit(Testimonial $testimonial): Response
    {
        return Inertia::render('Testimonials/Edit', [
            'testimonial' => $testimonial,
        ]);
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $this->validatedTestimonial($request);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $testimonial->update($validated);

        return Redirect::route('testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return Redirect::route('testimonials.index')->with('success', 'Testimonial deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedTestimonial(Request $request): array
    {
        return $request->validate([
            'quote' => ['required', 'string'],
            'author' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'initials' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:draft,published'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:99999'],
        ]);
    }
}
