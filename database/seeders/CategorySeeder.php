<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Carbon;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        Category::insert([
            [
                'name' => 'Laptops',
                'description' => 'Portable computers for personal and professional use.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Smartphones',
                'description' => 'Mobile phones with advanced features.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Accessories',
                'description' => 'Gadgets and peripherals to enhance your devices.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
