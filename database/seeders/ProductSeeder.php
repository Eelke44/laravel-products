<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->create([
            'name' => 'monitor',
            'description' => '27 inch 4K',
            'price' => 500,
        ]);

        Product::factory()->create([
            'name' => 'keyboard',
            'description' => 'Gateron Baby Kangaroo switches',
            'price' => 5000,
        ]);

        Product::factory()->create([
            'name' => 'mouse',
            'description' => '5 buttons, 1000dpi',
            'price' => 30,
        ]);
    }
}
