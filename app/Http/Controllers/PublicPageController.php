<?php

namespace App\Http\Controllers;

use App\Models\Educator;
use App\Models\Testimonial;
use App\Services\SiteContentRepository;
use Inertia\Inertia;
use Inertia\Response;

class PublicPageController extends Controller
{
    public function home(SiteContentRepository $siteContent): Response
    {
        $featuredTestimonials = Testimonial::query()
            ->published()
            ->featured()
            ->ordered()
            ->get();

        return Inertia::render('Welcome', [
            'featuredTestimonials' => $featuredTestimonials,
            'pageContent' => $siteContent->page('welcome'),
        ]);
    }

    public function about(SiteContentRepository $siteContent): Response
    {
        $testimonials = Testimonial::query()
            ->published()
            ->ordered()
            ->get();

        $principal = Educator::query()
            ->published()
            ->where('is_principal', true)
            ->ordered()
            ->first();

        $teachers = Educator::query()
            ->published()
            ->where('is_principal', false)
            ->ordered()
            ->get();

        return Inertia::render('About', [
            'testimonials' => $testimonials,
            'principal' => $principal,
            'teachers' => $teachers,
            'pageContent' => $siteContent->page('about'),
        ]);
    }
}
