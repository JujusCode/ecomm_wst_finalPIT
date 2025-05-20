<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $laptops = Category::where('name', 'Laptops')->first();
        $phones = Category::where('name', 'Smartphones')->first();
        $accessories = Category::where('name', 'Accessories')->first();

        $products = [
            [
                'name' => 'MacBook Pro 14"',
                'description' => 'Apple laptop with M1 Pro chip.',
                'price' => 2199.99,
                'stock' => 10,
                'image' => 'macbook.jpg',
                'category_id' => $laptops->id,
            ],
            [
                'name' => 'Dell XPS 13',
                'description' => 'Lightweight ultrabook with Intel i7.',
                'price' => 1299.99,
                'stock' => 15,
                'image' => 'xps13.jpg',
                'category_id' => $laptops->id,
            ],
            [
                'name' => 'HP Spectre x360',
                'description' => '2-in-1 convertible laptop.',
                'price' => 1149.00,
                'stock' => 8,
                'image' => 'spectre.jpg',
                'category_id' => $laptops->id,
            ],
            [
                'name' => 'Samsung Galaxy S23',
                'description' => 'Flagship Android smartphone.',
                'price' => 899.99,
                'stock' => 25,
                'image' => 'galaxy-s23.jpg',
                'category_id' => $phones->id,
            ],
            [
                'name' => 'iPhone 14 Pro',
                'description' => 'Latest Apple smartphone with Dynamic Island.',
                'price' => 999.99,
                'stock' => 20,
                'image' => 'iphone14pro.jpg',
                'category_id' => $phones->id,
            ],
            [
                'name' => 'Google Pixel 7',
                'description' => 'Clean Android experience with AI features.',
                'price' => 749.99,
                'stock' => 18,
                'image' => 'pixel7.jpg',
                'category_id' => $phones->id,
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Bluetooth mouse for all devices.',
                'price' => 29.99,
                'stock' => 50,
                'image' => 'mouse.jpg',
                'category_id' => $accessories->id,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB keyboard with blue switches.',
                'price' => 89.99,
                'stock' => 30,
                'image' => 'keyboard.jpg',
                'category_id' => $accessories->id,
            ],
            [
                'name' => 'USB-C Hub',
                'description' => '7-in-1 USB-C hub for laptops.',
                'price' => 49.99,
                'stock' => 40,
                'image' => 'usbc-hub.jpg',
                'category_id' => $accessories->id,
            ],
            [
                'name' => 'Noise Cancelling Headphones',
                'description' => 'Wireless over-ear headphones with ANC.',
                'price' => 199.99,
                'stock' => 12,
                'image' => 'headphones.jpg',
                'category_id' => $accessories->id,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
