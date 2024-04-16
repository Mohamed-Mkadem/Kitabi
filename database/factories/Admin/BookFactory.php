<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Author;
use App\Models\Admin\Category;
use App\Models\Admin\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'image' => fake()->imageUrl(),
            'status' => 'published',
            'category_id' => Category::factory(),
            'publisher_id' => Publisher::factory(),
            'author_id' => Author::factory(),
            'price' => rand(7000, 180000),
            'quantity' => rand(20, 200),
            'stock_alert' => rand(0, 70),
            'cost_price' => rand(7000, 180000),
            'description' => fake()->paragraph(2),
        ];
    }
}
