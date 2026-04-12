<?php

namespace App\Http\Controllers;

use App\Models\Educator;
use App\Models\Testimonial;
use Inertia\Inertia;
use Inertia\Response;

class PublicPageController extends Controller
{
    public function home(): Response
    {
        $featuredTestimonials = Testimonial::query()
            ->published()
            ->featured()
            ->ordered()
            ->get();

        return Inertia::render('Welcome', [
            'featuredTestimonials' => $featuredTestimonials,
        ]);
    }

    public function about(): Response
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
        ]);
    }
}
