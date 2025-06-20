<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sale::factory()->count(5)->create();

        Product::factory()->count(20)->create()->each(function ($product) {
            $noteIds = Note::inRandomOrder()->take(rand(2, 4))->pluck('id');
            $product->notes()->attach($noteIds);
        });
    }
}
