<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 products
        \App\Models\Product::factory(200)->create([
            'user_id' => 1, // Assuming you have a user with ID 1
        ]);
    }
}
