<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            [
                'quote' => 'Aletheia Resource Center gave my daughter not just an outstanding education, but the confidence and character to thrive wherever she goes. The teachers here truly know every child by name.',
                'author' => 'Mrs. Priya Menon',
                'role' => 'Parent, Year 10',
                'initials' => 'PM',
                'status' => 'published',
                'is_featured' => true,
                'sort_order' => 0,
            ],
            [
                'quote' => 'What sets this school apart is the genuine care for every student. My son has grown academically and personally in ways I never expected.',
                'author' => 'Mr. David Tan',
                'role' => 'Parent, Year 8',
                'initials' => 'DT',
                'status' => 'published',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'quote' => 'From the moment we walked through the doors, we knew this was the right place for our family. The academic rigour combined with a nurturing environment is exactly what we were looking for.',
                'author' => 'Mrs. Amira Hassan',
                'role' => 'Parent, Year 6',
                'initials' => 'AH',
                'status' => 'published',
                'is_featured' => false,
                'sort_order' => 2,
            ],
            [
                'quote' => 'The teachers go above and beyond. My daughter\'s love for science was sparked by a teacher here who believed in her potential before she believed in herself.',
                'author' => 'Mr. Kevin Loh',
                'role' => 'Parent, Year 11',
                'initials' => 'KL',
                'status' => 'published',
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'quote' => 'I have never felt more prepared for university. The support from our teachers and the opportunities available here are truly exceptional.',
                'author' => 'Adam Khalid',
                'role' => 'Alumni, Class of 2024',
                'initials' => 'AK',
                'status' => 'published',
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'quote' => 'Three of our children have gone through Aletheia, and each one has had a unique, personalised experience. That speaks volumes about the quality of care here.',
                'author' => 'Dr. & Mrs. Rajesh Kumar',
                'role' => 'Parents, Years 7, 9 & 12',
                'initials' => 'RK',
                'status' => 'published',
                'is_featured' => false,
                'sort_order' => 5,
            ],
        ];

        foreach ($rows as $row) {
            Testimonial::query()->create($row);
        }
    }
}
