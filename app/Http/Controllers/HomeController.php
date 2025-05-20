<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get the featured product for the main hero banner
        $featuredProduct = Product::where('stock', '>', 0)
            ->inRandomOrder()
            ->first();

        // Get three random products for the smaller banners
        $smallBannerProducts = Product::where('stock', '>', 0)
            ->when($featuredProduct, function ($query) use ($featuredProduct) {
                return $query->where('id', '!=', $featuredProduct->id);
            })
            ->inRandomOrder()
            ->take(3)
            ->get();

        // If we don't have 3 products, pad the array with nulls
        $smallBannerProducts = $smallBannerProducts->pad(3, null);

        // Count total products for the "Over X Products" text
        $totalProducts = Product::count();

        // Get random products for the featured products section (without is_featured check)
        $products = Product::where('stock', '>', 0)
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view('welcome', compact('featuredProduct', 'smallBannerProducts', 'totalProducts', 'products'));
    }
}