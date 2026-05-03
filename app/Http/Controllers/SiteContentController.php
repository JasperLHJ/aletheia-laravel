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
    private const SECTION_DESCRIPTIONS = [
        'meta'          => 'SEO title and description shown in search results and the browser tab.',
        'hero'          => 'The large banner at the top of the page.',
        'stats'         => 'The key statistics and numbers row.',
        'highlights'    => 'The feature cards displayed below the stats row.',
        'galleryTeaser' => 'The gallery preview strip on the home page.',
        'testimonials'  => 'The testimonials section heading and empty-state message.',
        'enquiryCta'    => 'The call-to-action block prompting visitors to enquire.',
        'social'        => 'The social media section headings and link labels.',
        'seo'           => 'Global SEO defaults — site name, description, and organisation details.',
        'brand'         => 'The site name shown in the navigation header.',
        'nav'           => 'Navigation menu link labels.',
        'footer'        => 'Footer text, copyright, and column headings.',
        'floatingWhatsapp' => 'The floating WhatsApp button label.',
        'enquiryAnchor' => 'The enquiry anchor / scroll-to label.',
        'form'          => 'Contact form labels, placeholders, and response messages.',
        'visit'         => 'Address, office hours, and directions cards.',
        'map'           => 'Map section heading and labels.',
        'ctaSection'    => 'The "Choose How to Connect" contact cards.',
        'overview'      => 'The overview / introductory section.',
        'deepDive'      => 'The in-depth programme detail section.',
        'whyChoose'     => 'The "Why Choose Us" section.',
        'grid'          => 'The gallery grid headings and category labels.',
        'listing'       => 'The blog listing section headings.',
    ];

    public function __construct(
        private readonly SiteContentRepository $siteContent,
        private readonly SiteContentTextFormService $textForm,
    ) {}

    public function index(): Response
    {
        $documents = $this->siteContent->documentLabels();
        $urls = config('site-content.document_urls', []);
        $items = [];
        foreach ($documents as $slug => $label) {
            $items[] = [
                'slug'    => $slug,
                'label'   => $label,
                'pageUrl' => $urls[$slug] ?? null,
            ];
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

        $urls = config('site-content.document_urls', []);

        return Inertia::render('SiteContent/Edit', [
            'document' => $document,
            'label'    => $this->siteContent->documentLabels()[$document] ?? $document,
            'sections' => $this->groupFieldsIntoSections($fields),
            'pageUrl'  => $urls[$document] ?? null,
            'intro'    => 'Edit the text that appears on your website. Photos, image paths, and link URLs are not shown here and stay unchanged.',
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
                    'key'         => $top,
                    'title'       => Str::headline(str_replace(['-', '_'], ' ', $top)),
                    'description' => self::SECTION_DESCRIPTIONS[$top] ?? null,
                    'fields'      => [],
                ];
            }
            $groups[$top]['fields'][] = $field;
        }

        return array_values($groups);
    }
}
