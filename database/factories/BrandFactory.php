<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brandNames = [
            'Armani', 'Dolce & Gabanna', 'Burberry', 'Dior', 'Carolina Herrera',
            'Kenzo', 'Versace', 'Montblanc', 'Luis Vuitton', 'Creed'
        ];
        $name = $this->faker->unique()->randomElement($brandNames);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => $this->faker->imageUrl(640, 480, 'fashion', true, 'brand'), // Maybe 'brand' is better than 'perfume'
        ];
    }
}
