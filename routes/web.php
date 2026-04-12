<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EducatorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBlogController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PublicPageController::class, 'home'])->name('home');

Route::get('/about', [PublicPageController::class, 'about'])->name('about');

Route::get('/gallery', function () {
    return Inertia::render('Gallery');
})->name('gallery');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/programmes', function () {
    return Inertia::render('Programmes');
})->name('programmes');

Route::get('/blog', [PublicBlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [PublicBlogController::class, 'show'])->name('blog.show');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('blogs', BlogController::class)->parameters([
        'blogs' => 'post',
    ]);

    Route::resource('testimonials', TestimonialController::class);

    Route::resource('educators', EducatorController::class);
});

require __DIR__.'/auth.php';
