<?php

namespace App\Http\Controllers;

use App\Services\SiteContentRepository;
use App\Services\SiteContentTextFormService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SiteContentImageController extends Controller
{
    public function __construct(
        private readonly SiteContentRepository $siteContent,
        private readonly SiteContentTextFormService $textForm,
    ) {}

    public function store(Request $request, string $document): JsonResponse
    {
        if (! $this->siteContent->isAllowedDocument($document)) {
            abort(404);
        }

        $request->validate([
            'path' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'image', 'max:5120', 'mimes:jpg,jpeg,png,gif,webp,avif'],
        ]);

        $data = $document === 'site'
            ? $this->siteContent->site()
            : $this->siteContent->page($document);

        $allowedPaths = array_column($this->textForm->imageFieldDefinitions($data), 'path');
        $dotPath = $request->input('path');

        if (! in_array($dotPath, $allowedPaths, true)) {
            abort(422, 'Image path not allowed.');
        }

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $filename = Str::uuid().'.'.$extension;
        $storagePath = "site-content/{$document}/{$filename}";

        Storage::disk('public')->putFileAs(
            "site-content/{$document}",
            $file,
            $filename,
        );

        $publicUrl = '/storage/'.$storagePath;

        $updated = data_set($data, $dotPath, $publicUrl);
        $this->siteContent->save($document, $updated);

        return response()->json(['url' => $publicUrl]);
    }
}
