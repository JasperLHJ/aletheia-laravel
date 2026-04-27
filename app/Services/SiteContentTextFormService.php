<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SiteContentTextFormService
{
    /**
     * Keys (anywhere in the tree) whose values are not editable — URLs, image paths, layout tokens, SVG, etc.
     *
     * @var list<string>
     */
    private const BLOCKED_KEYS = [
        'image',
        'src',
        'backgroundImage',
        'defaultImage',
        'logo',
        'iframeSrc',
        'href',
        'sameAs',
        'themeColor',
        'categoryAccentColors',
        'icon',
        'dotClass',
        'accentColor',
        'overlayColor',
        'headingClass',
        'textClass',
        'accentBg',
        'accentText',
        'accentBorder',
        'hoverRing',
        'anchor',
        'id',
        'contactHref',
        'directionsHref',
        'openMapsHref',
        'galleryHref',
        'ctaHref',
    ];

    /**
     * @return list<array{path: string, label: string, control: 'text'|'textarea', value: string, help: string|null}>
     */
    public function fieldDefinitions(array $data): array
    {
        $flat = [];
        $this->walk($data, '', $flat);

        $out = [];
        foreach ($flat as $path => $meta) {
            $out[] = [
                'path' => $path,
                'label' => $this->labelForPath($path),
                'control' => $meta['control'],
                'value' => $meta['value'],
                'help' => $meta['help'],
            ];
        }

        return $out;
    }

    /**
     * @param  array<string, string>  $submitted  path => raw string from form
     * @return array<string, mixed>
     */
    public function applySubmitted(array $base, array $submitted, array $allowedPaths): array
    {
        $merged = $base;
        $allowed = array_flip($allowedPaths);

        foreach ($submitted as $path => $raw) {
            if (! isset($allowed[$path])) {
                continue;
            }
            if (! is_string($raw)) {
                continue;
            }
            $this->assignAtPath($merged, $path, $raw, Arr::get($base, $path));
        }

        return $merged;
    }

    /**
     * @param  array<string, mixed>  $flat
     */
    private function walk(mixed $value, string $path, array &$flat): void
    {
        if (is_string($value)) {
            $flat[$path] = [
                'control' => strlen($value) > 160 ? 'textarea' : 'text',
                'value' => $value,
                'help' => $this->helpForPath($path),
            ];

            return;
        }

        if (is_int($value) || is_float($value)) {
            $flat[$path] = [
                'control' => 'text',
                'value' => (string) $value,
                'help' => null,
            ];

            return;
        }

        if (! is_array($value)) {
            return;
        }

        if ($this->isListOfStrings($value)) {
            $flat[$path] = [
                'control' => 'textarea',
                'value' => implode("\n", $value),
                'help' => 'One line per item.',
            ];

            return;
        }

        if (array_is_list($value)) {
            foreach ($value as $i => $item) {
                $childPath = ltrim($path.'.'.$i, '.');
                $this->walk($item, $childPath, $flat);
            }

            return;
        }

        foreach ($value as $key => $child) {
            if (! is_string($key) || in_array($key, self::BLOCKED_KEYS, true)) {
                continue;
            }
            $childPath = ltrim($path.'.'.$key, '.');
            $this->walk($child, $childPath, $flat);
        }
    }

    /**
     * @param  array<mixed>  $value
     */
    private function isListOfStrings(array $value): bool
    {
        if (! array_is_list($value)) {
            return false;
        }

        if ($value === []) {
            return true;
        }

        foreach ($value as $item) {
            if (! is_string($item)) {
                return false;
            }
        }

        return true;
    }

    private function labelForPath(string $path): string
    {
        return Str::headline(str_replace(['.', '-'], ' ', $path));
    }

    private function helpForPath(string $path): ?string
    {
        if (str_contains($path, 'Html')) {
            return 'HTML is allowed where the public page expects it.';
        }

        return null;
    }

    /**
     * @param  array<string|int, mixed>  $merged
     */
    private function assignAtPath(array &$merged, string $path, string $raw, mixed $original): void
    {
        if (is_array($original) && $this->isListOfStrings($original)) {
            $lines = preg_split("/\r\n|\r|\n/", $raw) ?: [];
            $lines = array_values(array_filter(array_map('trim', $lines), fn ($l) => $l !== ''));

            Arr::set($merged, $path, $lines);

            return;
        }

        if (is_int($original)) {
            if (preg_match('/^-?\d+$/', trim($raw))) {
                Arr::set($merged, $path, (int) $raw);
            } else {
                Arr::set($merged, $path, $original);
            }

            return;
        }

        if (is_float($original)) {
            Arr::set($merged, $path, is_numeric(trim($raw)) ? (float) $raw : $original);

            return;
        }

        Arr::set($merged, $path, $raw);
    }
}
