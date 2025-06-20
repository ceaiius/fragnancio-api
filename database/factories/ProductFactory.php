<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isOnSale = $this->faker->boolean(30); 
        $sale = $isOnSale ? Sale::inRandomOrder()->first() ?? Sale::factory()->create() : null;

        return [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 30, 300),
            'size' => $this->faker->randomElement([5, 30, 50, 75, 100, 200]),
            'condition' => $this->faker->randomElement(['new with box', 'new without box', 'used']),
            'image' => $this->faker->imageUrl(640, 480, 'fashion', true, 'perfume'),
            'gender' => $this->faker->randomElement(['men', 'women', 'unisex']),
            'brand_id' => \App\Models\Brand::inRandomOrder()->first()?->id ?? \App\Models\Brand::factory(),
            'category_id' => \App\Models\Category::inRandomOrder()->first()?->id ?? \App\Models\Category::factory(),
            'sale_id' => $sale?->id,
        ];
    }
}
