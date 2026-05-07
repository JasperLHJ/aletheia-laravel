<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SiteContentTextFormService
{
    /**
     * Image path keys that are exposed as uploadable fields in the CMS.
     * These are excluded from the text form but returned by imageFieldDefinitions().
     *
     * @var list<string>
     */
    private const IMAGE_KEYS = [
        'image',
        'backgroundImage',
        'defaultImage',
        'logo',
    ];

    /**
     * Keys (anywhere in the tree) whose values are not editable — URLs, image paths, layout tokens, SVG, etc.
     * Pattern-based blocking is also applied in isBlockedKey(): any key whose name contains "aria" (case-insensitive)
     * or ends with "Href" / "Url" / "Src" is automatically suppressed.
     *
     * @var list<string>
     */
    private const BLOCKED_KEYS = [
        // Images / media paths (IMAGE_KEYS are handled separately)
        'src',
        'iframeSrc',
        // URLs (bare key — compound variants like whatsappHref caught by suffix pattern)
        'href',
        'sameAs',
        // Styling / CSS tokens
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
        'iconBg',
        'accentLine',
        // Internal navigation anchors
        'anchor',
        'id',
        // Accessibility / screen-reader only (most caught by 'aria' pattern; belt-and-braces below)
        'headingSrOnly',
        'iframeTitle',
        'hoursMuted',
        // Empty-state messages (developer fallback copy, not primary content)
        'emptyTitle',
        'emptyBody',
        'emptyMessage',
        'empty',
        'filteredEmptyTitle',
        'filteredEmptyBody',
        // Pluralisation / read-time format tokens
        'photoWordOne',
        'photoWordMany',
        'readTimeSuffix',
        'readTimeShort',
        'readArrow',
        // Navigation / hero micro-copy decorations
        'scrollLabel',
        'jumpToLabel',
        // Technical SEO / config
        'locale',
        'twitterHandle',
        // UI internals
        'comparisonRowLabel',
        'noPhoto',
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
            if (! is_string($key) || $this->isBlockedKey($key)) {
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

    /**
     * @return list<array{path: string, label: string, control: 'image', value: string}>
     */
    public function imageFieldDefinitions(array $data): array
    {
        $flat = [];
        $this->walkImages($data, '', $flat);

        $out = [];
        foreach ($flat as $path => $value) {
            $out[] = [
                'path'  => $path,
                'label' => $this->labelForPath($path),
                'control' => 'image',
                'value' => $value,
            ];
        }

        return $out;
    }

    /**
     * @param  array<string, mixed>  $flat
     */
    private function walkImages(mixed $value, string $path, array &$flat): void
    {
        if (! is_array($value)) {
            return;
        }

        if (array_is_list($value)) {
            foreach ($value as $i => $item) {
                $this->walkImages($item, ltrim($path.'.'.$i, '.'), $flat);
            }

            return;
        }

        foreach ($value as $key => $child) {
            if (! is_string($key)) {
                continue;
            }
            $childPath = ltrim($path.'.'.$key, '.');
            if (in_array($key, self::IMAGE_KEYS, true) && is_string($child)) {
                $flat[$childPath] = $child;
            } else {
                $this->walkImages($child, $childPath, $flat);
            }
        }
    }

    private function isBlockedKey(string $key): bool
    {
        if (in_array($key, self::BLOCKED_KEYS, true)) {
            return true;
        }

        if (in_array($key, self::IMAGE_KEYS, true)) {
            return true;
        }

        // Block all ARIA / accessibility attributes regardless of prefix or suffix.
        if (stripos($key, 'aria') !== false) {
            return true;
        }

        // Block any URL / path field expressed as a compound key (e.g. whatsappHref, logoSrc).
        if (str_ends_with($key, 'Href') || str_ends_with($key, 'Url') || str_ends_with($key, 'Src')) {
            return true;
        }

        return false;
    }

    private function labelForPath(string $path): string
    {
        $segments = explode('.', $path);

        // Strip the top-level segment — it is already shown as the section card title.
        if (count($segments) > 1) {
            array_shift($segments);
        }

        $parts = [];
        foreach ($segments as $seg) {
            if (is_numeric($seg)) {
                // Collapse "parentKey, N" → "Parent Singular N"
                $last = array_pop($parts) ?? 'Item';
                $parts[] = Str::singular($last).' '.((int) $seg + 1);
            } else {
                $parts[] = Str::headline(str_replace('-', ' ', $seg));
            }
        }

        return implode(': ', array_filter($parts));
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
