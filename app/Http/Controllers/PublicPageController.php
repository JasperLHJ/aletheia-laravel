<?php

namespace App\Http\Controllers;

use App\Models\Educator;
use App\Models\Testimonial;
use App\Services\SiteContentRepository;
use App\Support\Seo\SeoBuilder;
use Inertia\Inertia;
use Inertia\Response;

class PublicPageController extends Controller
{
    public function home(SiteContentRepository $siteContent, SeoBuilder $seo): Response
    {
        $featuredTestimonials = Testimonial::query()
            ->published()
            ->featured()
            ->ordered()
            ->get();

        return Inertia::render('Welcome', [
            'featuredTestimonials' => $featuredTestimonials,
            'pageContent' => $siteContent->page('welcome'),
        ])->withViewData('seo', $seo->forPage('welcome')->toArray());
    }

    public function about(SiteContentRepository $siteContent, SeoBuilder $seo): Response
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
        ])->withViewData('seo', $seo->forPage('about')->toArray());
    }
}
