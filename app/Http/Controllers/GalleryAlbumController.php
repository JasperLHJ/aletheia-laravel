<?php

namespace App\Http\Controllers;

use App\Services\SiteContentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GalleryAlbumController extends Controller
{
    public function __construct(
        private readonly SiteContentRepository $siteContent,
    ) {}

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'albumUrl' => ['required', 'url', 'max:2048'],
            'title'    => ['required', 'string', 'max:255'],
        ]);

        $coverUrl = $this->fetchCoverUrl($validated['albumUrl']);

        if ($coverUrl === null) {
            return response()->json([
                'message' => 'Could not load a cover image. Make sure the album is publicly shared.',
            ], 422);
        }

        // Replace Google Photos size parameters with a high-resolution variant
        $coverUrl = preg_replace('/=w\d+(-h\d+)?(-[a-z-]+)*$/i', '=w1600', $coverUrl) ?? $coverUrl;

        $data = $this->siteContent->page('gallery');

        $album = [
            'albumUrl' => $validated['albumUrl'],
            'coverUrl' => $coverUrl,
            'title'    => $validated['title'],
            'alt'      => 'Cover photo from ' . $validated['title'] . ' album',
        ];

        $data['grid']['albums'][] = $album;

        $this->siteContent->save('gallery', $data);

        return response()->json(['album' => $album], 201);
    }

    public function destroy(Request $request, int $index): JsonResponse
    {
        $data = $this->siteContent->page('gallery');
        $albums = $data['grid']['albums'] ?? [];

        if (! isset($albums[$index])) {
            return response()->json(['message' => 'Album not found.'], 404);
        }

        array_splice($albums, $index, 1);
        $data['grid']['albums'] = array_values($albums);

        $this->siteContent->save('gallery', $data);

        return response()->json(['message' => 'Album removed.']);
    }

    private function fetchCoverUrl(string $albumUrl): ?string
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (compatible; AletheiaCMS/1.0)',
                'Accept'     => 'text/html,application/xhtml+xml',
            ])
                ->withoutVerifying()
                ->timeout(15)
                ->get($albumUrl);

            if (! $response->successful()) {
                return null;
            }

            $html = $response->body();

            // og:image — prefer property= form, fall back to name= form
            if (preg_match('/<meta[^>]+property=["\']og:image["\'][^>]+content=["\']([^"\']+)["\'][^>]*>/i', $html, $m)) {
                return $m[1];
            }
            if (preg_match('/<meta[^>]+content=["\']([^"\']+)["\'][^>]+property=["\']og:image["\'][^>]*>/i', $html, $m)) {
                return $m[1];
            }
        } catch (\Throwable) {
            // fall through
        }

        return null;
    }
}
