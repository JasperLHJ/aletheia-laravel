<?php

namespace Database\Factories;

use App\Models\Educator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Educator>
 */
class EducatorFactory extends Factory
{
    protected $model = Educator::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'title' => fake()->jobTitle(),
            'image' => '/images/class-'.fake()->numberBetween(1, 3).'.jpg',
            'bio' => fake()->paragraph(),
            'detail' => fake()->paragraphs(3, true),
            'is_principal' => false,
            'status' => 'published',
            'sort_order' => 0,
        ];
    }
}
