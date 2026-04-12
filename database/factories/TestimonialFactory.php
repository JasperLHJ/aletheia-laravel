<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $author = fake()->name();

        return [
            'quote' => fake()->paragraphs(2, true),
            'author' => $author,
            'role' => fake()->jobTitle(),
            'initials' => Testimonial::initialsFromAuthor($author),
            'status' => 'published',
            'is_featured' => false,
            'sort_order' => 0,
        ];
    }
}
