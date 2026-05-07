<?php

namespace App\Http\Controllers;

use App\Services\SiteContentRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class SiteContentBackupController extends Controller
{
    private const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];

    public function __construct(
        private readonly SiteContentRepository $siteContent,
    ) {}

    public function download(): StreamedResponse
    {
        $jsonDir = config('site-content.path');
        $timestamp = now()->format('Ymd-His');
        $zipFilename = "site-content-backup-{$timestamp}.zip";

        return response()->streamDownload(function () use ($jsonDir) {
            $zip = new ZipArchive();
            $tmpPath = tempnam(sys_get_temp_dir(), 'site-content-backup-');

            if ($zip->open($tmpPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new \RuntimeException('Could not create backup ZIP.');
            }

            foreach (glob($jsonDir.DIRECTORY_SEPARATOR.'*.json') ?: [] as $jsonFile) {
                $zip->addFile($jsonFile, 'json/'.basename($jsonFile));
            }

            if (Storage::disk('public')->exists('site-content')) {
                $imageFiles = Storage::disk('public')->allFiles('site-content');
                foreach ($imageFiles as $relative) {
                    $ext = strtolower(pathinfo($relative, PATHINFO_EXTENSION));
                    if (in_array($ext, self::IMAGE_EXTENSIONS, true)) {
                        $absolutePath = Storage::disk('public')->path($relative);
                        $zip->addFile($absolutePath, 'images/'.$relative);
                    }
                }
            }

            $zip->close();

            readfile($tmpPath);
            @unlink($tmpPath);
        }, $zipFilename, [
            'Content-Type' => 'application/zip',
        ]);
    }

    public function restore(Request $request): RedirectResponse
    {
        $request->validate([
            'backup' => ['required', 'file', 'mimes:zip', 'max:102400'],
        ]);

        $zip = new ZipArchive();
        $tmpPath = $request->file('backup')->getRealPath();

        if ($zip->open($tmpPath) !== true) {
            return Redirect::route('site-content.index')
                ->with('error', 'Could not open the backup file.');
        }

        $allowedSlugs = array_keys($this->siteContent->documentLabels());
        $jsonDir = config('site-content.path');
        $restoredJson = 0;
        $restoredImages = 0;

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $name = $zip->getNameIndex($i);

            if ($name === false) {
                continue;
            }

            if (str_starts_with($name, 'json/') && str_ends_with($name, '.json')) {
                $basename = basename($name);
                $slug = str_replace('.json', '', $basename);

                if (! in_array($slug, $allowedSlugs, true)) {
                    continue;
                }

                $content = $zip->getFromIndex($i);
                if ($content === false) {
                    continue;
                }

                try {
                    $decoded = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
                } catch (\JsonException) {
                    Log::warning('Backup restore: invalid JSON skipped', ['file' => $name]);
                    continue;
                }

                if (! is_array($decoded)) {
                    continue;
                }

                $destination = $jsonDir.DIRECTORY_SEPARATOR.$basename;
                file_put_contents($destination, $content);
                $restoredJson++;
            }

            if (str_starts_with($name, 'images/site-content/')) {
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if (! in_array($ext, self::IMAGE_EXTENSIONS, true)) {
                    continue;
                }

                $relative = substr($name, strlen('images/'));
                $content = $zip->getFromIndex($i);
                if ($content === false) {
                    continue;
                }

                Storage::disk('public')->put($relative, $content);
                $restoredImages++;
            }
        }

        $zip->close();

        $message = "Backup restored: {$restoredJson} content file(s) and {$restoredImages} image(s) imported.";

        return Redirect::route('site-content.index')->with('success', $message);
    }
}
