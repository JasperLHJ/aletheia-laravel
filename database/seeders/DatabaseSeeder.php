<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('password'),
        ]);

        $categories = Category::factory(5)->create();
        Post::factory(10)->create([
            'user_id' => $user->id,
        ])->each(fn (Post $post) => $post->update(['category_id' => $categories->random()->id]));
        Product::factory(15)->create()->each(fn (Product $product) => $product->update(['category_id' => $categories->random()->id]));
    }
}
