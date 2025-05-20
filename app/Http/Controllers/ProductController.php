<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->paginate(12);
        return view('products.indexProduct', compact('products'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        // Load any related products (products in the same category)
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('products.showProduct', compact('product', 'relatedProducts'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Perform the search
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->where('stock', '>', 0)
            ->paginate(12);

        // Check if we have a results view
        if (view()->exists('products.search')) {
            return view('products.search', compact('products', 'query'));
        }

        // Fallback to the index view with the search results
        return view('products.indexProduct', compact('products', 'query'));
    }
}