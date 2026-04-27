<?php

namespace App\Http\Requests;

use App\Services\SiteContentRepository;
use App\Services\SiteContentTextFormService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateSiteContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'fields' => ['required', 'array'],
            'fields.*' => ['nullable', 'string', 'max:100000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $document = $this->route('document');
            if (! is_string($document)) {
                return;
            }

            $repo = app(SiteContentRepository::class);
            $textForm = app(SiteContentTextFormService::class);

            if (! $repo->isAllowedDocument($document)) {
                return;
            }

            $base = $document === 'site' ? $repo->site() : $repo->page($document);
            $allowed = array_map(fn ($d) => $d['path'], $textForm->fieldDefinitions($base));
            $allowedFlip = array_flip($allowed);

            $submitted = $this->input('fields', []);
            if (! is_array($submitted)) {
                return;
            }

            foreach (array_keys($submitted) as $path) {
                if (! is_string($path) || ! isset($allowedFlip[$path])) {
                    $validator->errors()->add('fields', 'This form is out of date. Refresh the page and try again.');
                    break;
                }
            }
        });
    }

    /**
     * @return array<string, string>
     */
    public function submittedFields(): array
    {
        /** @var array<mixed, mixed> $fields */
        $fields = $this->validated('fields');
        $out = [];
        foreach ($fields as $path => $value) {
            if (! is_string($path)) {
                continue;
            }
            $out[$path] = is_string($value) ? $value : '';
        }

        return $out;
    }
}
