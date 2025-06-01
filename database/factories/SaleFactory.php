<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-10 days', '+1 days');
        return [
            'sale_price' => $this->faker->randomFloat(2, 10, 49),
            'starts_at' => $start,
            'ends_at' => $this->faker->optional()->dateTimeBetween($start, '+10 days'),
        ];
    }
}
