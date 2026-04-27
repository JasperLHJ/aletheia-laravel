<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSiteContentRequest;
use App\Services\SiteContentRepository;
use App\Services\SiteContentTextFormService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class SiteContentController extends Controller
{
    public function __construct(
        private readonly SiteContentRepository $siteContent,
        private readonly SiteContentTextFormService $textForm,
    ) {}

    public function index(): Response
    {
        $documents = $this->siteContent->documentLabels();
        $items = [];
        foreach ($documents as $slug => $label) {
            $items[] = ['slug' => $slug, 'label' => $label];
        }

        return Inertia::render('SiteContent/Index', [
            'documents' => $items,
        ]);
    }

    public function edit(string $document): Response
    {
        if (! $this->siteContent->isAllowedDocument($document)) {
            abort(404);
        }

        $data = $document === 'site'
            ? $this->siteContent->site()
            : $this->siteContent->page($document);

        $fields = $this->textForm->fieldDefinitions($data);

        return Inertia::render('SiteContent/Edit', [
            'document' => $document,
            'label' => $this->siteContent->documentLabels()[$document] ?? $document,
            'sections' => $this->groupFieldsIntoSections($fields),
            'intro' => 'Edit the text that appears on your website. Photos, image paths, and link URLs are not shown here and stay unchanged.',
        ]);
    }

    public function update(UpdateSiteContentRequest $request, string $document): RedirectResponse
    {
        if (! $this->siteContent->isAllowedDocument($document)) {
            abort(404);
        }

        $base = $document === 'site'
            ? $this->siteContent->site()
            : $this->siteContent->page($document);

        $allowed = array_map(fn ($d) => $d['path'], $this->textForm->fieldDefinitions($base));
        $merged = $this->textForm->applySubmitted($base, $request->submittedFields(), $allowed);

        $this->siteContent->save($document, $merged);

        return Redirect::route('site-content.edit', $document)
            ->with('success', 'Site content saved.');
    }

    /**
     * @param  list<array{path: string, label: string, control: string, value: string, help: string|null}>  $fields
     * @return list<array{key: string, title: string, fields: list<array{path: string, label: string, control: string, value: string, help: string|null}>}>
     */
    private function groupFieldsIntoSections(array $fields): array
    {
        $groups = [];
        foreach ($fields as $field) {
            $top = explode('.', $field['path'])[0] ?: 'general';
            if (! isset($groups[$top])) {
                $groups[$top] = [
                    'key' => $top,
                    'title' => Str::headline(str_replace(['-', '_'], ' ', $top)),
                    'fields' => [],
                ];
            }
            $groups[$top]['fields'][] = $field;
        }

        return array_values($groups);
    }
}
