<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class StaffProductController extends Controller
{
    /**
     * Display a listing of the products (inventory view).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('staff.products.index', compact('products'));
    }

    /**
     * Show the form for editing the specified product (inventory only).
     */
    public function edit(Product $product)
    {
        return view('staff.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage (stock only).
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product->update([
            'stock' => $validated['stock'],
        ]);

        return redirect()->route('staff.products.index')
            ->with('success', 'Product inventory updated successfully.');
    }

    /**
     * Show the specified product (read-only view).
     */
    public function show(Product $product)
    {
        return view('staff.products.show', compact('product'));
    }
}