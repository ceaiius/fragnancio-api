<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $noteNames = [
            'Woody', 'Citrus', 'Floral', 'Fruity', 'Oriental',
            'Aquatic', 'Spicy', 'Musk', 'Green', 'Leather'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($noteNames),
        ];
    }
}
