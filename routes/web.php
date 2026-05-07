<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EducatorController;
use App\Http\Controllers\GalleryAlbumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBlogController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\SiteContentBackupController;
use App\Http\Controllers\SiteContentController;
use App\Http\Controllers\SiteContentImageController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TestimonialController;
use App\Services\SiteContentRepository;
use App\Support\Seo\SeoBuilder;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PublicPageController::class, 'home'])->name('home');

Route::get('/about', [PublicPageController::class, 'about'])->name('about');

Route::get('/gallery', function (SiteContentRepository $siteContent, SeoBuilder $seo) {
    return Inertia::render('Gallery', [
        'pageContent' => $siteContent->page('gallery'),
    ])->withViewData('seo', $seo->forPage('gallery')->toArray());
})->name('gallery');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/programmes', function (SiteContentRepository $siteContent, SeoBuilder $seo) {
    return Inertia::render('Programmes', [
        'pageContent' => $siteContent->page('programmes'),
    ])->withViewData('seo', $seo->forPage('programmes')->toArray());
})->name('programmes');

Route::get('/blog', [PublicBlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [PublicBlogController::class, 'show'])->name('blog.show');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'noindex'])->name('dashboard');

Route::middleware(['auth', 'verified', 'noindex'])->group(function () {
    $siteContentDocuments = implode('|', array_keys(config('site-content.documents')));

    Route::get('/site-content', [SiteContentController::class, 'index'])->name('site-content.index');
    Route::get('/site-content/{document}/edit', [SiteContentController::class, 'edit'])
        ->where('document', $siteContentDocuments)
        ->name('site-content.edit');
    Route::put('/site-content/{document}', [SiteContentController::class, 'update'])
        ->where('document', $siteContentDocuments)
        ->name('site-content.update');
    Route::post('/site-content/{document}/images', [SiteContentImageController::class, 'store'])
        ->where('document', $siteContentDocuments)
        ->name('site-content.images.store');

    Route::post('/site-content/gallery/albums', [GalleryAlbumController::class, 'store'])
        ->name('gallery.albums.store');
    Route::delete('/site-content/gallery/albums/{index}', [GalleryAlbumController::class, 'destroy'])
        ->name('gallery.albums.destroy');

    Route::get('/site-content/backup/download', [SiteContentBackupController::class, 'download'])
        ->name('site-content.backup.download');
    Route::post('/site-content/backup/restore', [SiteContentBackupController::class, 'restore'])
        ->name('site-content.backup.restore');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('blogs/scrape', [BlogController::class, 'scrape'])->name('blogs.scrape');

    Route::resource('blogs', BlogController::class)->parameters([
        'blogs' => 'post',
    ]);

    Route::resource('testimonials', TestimonialController::class);

    Route::resource('educators', EducatorController::class);
});

require __DIR__.'/auth.php';
