<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('###'),
            'body' => '<p>'.implode('</p><p>', fake()->paragraphs(3)).'</p>',
            'excerpt' => fake()->paragraph(),
            'featured_image' => '/images/class-2.jpg',
            'reading_time_minutes' => fake()->numberBetween(2, 8),
            'is_featured' => false,
            'category' => fake()->randomElement(['Events', 'Achievements', 'Campus Life', 'Academic', 'Community']),
            'published_at' => fake()->dateTimeBetween('-3 months', 'now'),
            'status' => fake()->randomElement(['draft', 'published']),
            'user_id' => User::factory(),
        ];
    }
}
