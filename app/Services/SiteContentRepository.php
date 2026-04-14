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
}
