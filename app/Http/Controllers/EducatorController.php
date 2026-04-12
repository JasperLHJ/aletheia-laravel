<?php

namespace App\Http\Controllers;

use App\Models\Educator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class EducatorController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Educators/Index', [
            'educators' => Educator::query()
                ->ordered()
                ->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Educators/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedEducator($request);
        $validated['is_principal'] = $request->boolean('is_principal');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $educator = Educator::create($validated);
        $this->ensureSinglePrincipal($educator);

        return Redirect::route('educators.index')->with('success', 'Educator created.');
    }

    public function show(Educator $educator): Response
    {
        return Inertia::render('Educators/View', [
            'educator' => $educator,
        ]);
    }

    public function edit(Educator $educator): Response
    {
        return Inertia::render('Educators/Edit', [
            'educator' => $educator,
        ]);
    }

    public function update(Request $request, Educator $educator): RedirectResponse
    {
        $validated = $this->validatedEducator($request);
        $validated['is_principal'] = $request->boolean('is_principal');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $educator->update($validated);
        $this->ensureSinglePrincipal($educator);

        return Redirect::route('educators.index')->with('success', 'Educator updated.');
    }

    public function destroy(Educator $educator): RedirectResponse
    {
        $educator->delete();

        return Redirect::route('educators.index')->with('success', 'Educator deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedEducator(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:500'],
            'bio' => ['required', 'string'],
            'detail' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:99999'],
        ]);
    }

    private function ensureSinglePrincipal(Educator $current): void
    {
        if (! $current->is_principal) {
            return;
        }

        Educator::query()
            ->where('id', '!=', $current->id)
            ->update(['is_principal' => false]);
    }
}
