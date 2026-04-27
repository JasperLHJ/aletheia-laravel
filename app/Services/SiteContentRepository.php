<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use JsonException;

class SiteContentRepository
{
    public function site(): array
    {
        return $this->load('site.json');
    }

    public function page(string $name): array
    {
        return $this->load($name.'.json');
    }

    /**
     * @return array<string, string> slug => label
     */
    public function documentLabels(): array
    {
        $documents = config('site-content.documents');

        return is_array($documents) ? $documents : [];
    }

    public function isAllowedDocument(string $slug): bool
    {
        return array_key_exists($slug, $this->documentLabels());
    }

    /**
     * Persist a whitelisted document. Writes JSON atomically.
     *
     * @param  array<string, mixed>  $data
     */
    public function save(string $slug, array $data): void
    {
        if (! $this->isAllowedDocument($slug)) {
            throw new \InvalidArgumentException("Unknown site content document: {$slug}");
        }

        $path = $this->resolvedPathForSlug($slug);
        $resolvedDir = realpath(dirname($path));

        if ($resolvedDir === false) {
            throw new \RuntimeException('Site content directory not found.');
        }

        $normalizedPath = $resolvedDir.DIRECTORY_SEPARATOR.basename($path);

        try {
            $payload = json_encode(
                $data,
                JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
            )."\n";
        } catch (JsonException $e) {
            throw new \RuntimeException('Could not encode site content as JSON.', 0, $e);
        }

        $tmp = tempnam($resolvedDir, '.site-content.');
        if ($tmp === false) {
            throw new \RuntimeException('Could not create temporary file for site content.');
        }

        try {
            if (file_put_contents($tmp, $payload) === false) {
                throw new \RuntimeException('Could not write site content temporary file.');
            }

            if (! rename($tmp, $normalizedPath)) {
                throw new \RuntimeException('Could not replace site content file.');
            }
        } catch (\Throwable $e) {
            if (is_file($tmp)) {
                @unlink($tmp);
            }
            throw $e;
        }
    }

    private function load(string $filename): array
    {
        $dir = config('site-content.path');
        $path = $dir.DIRECTORY_SEPARATOR.$filename;

        if (! File::isFile($path)) {
            Log::error('Site content file missing', ['path' => $path]);

            throw new \RuntimeException("Site content file not found: {$filename}");
        }

        try {
            $decoded = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            Log::error('Site content JSON invalid', ['path' => $path, 'message' => $e->getMessage()]);

            throw new \RuntimeException("Invalid site content JSON: {$filename}", 0, $e);
        }

        return is_array($decoded) ? $decoded : [];
    }

    private function resolvedPathForSlug(string $slug): string
    {
        $basename = $slug === 'site' ? 'site.json' : $slug.'.json';
        $baseDir = config('site-content.path');

        return $baseDir.DIRECTORY_SEPARATOR.$basename;
    }
}
