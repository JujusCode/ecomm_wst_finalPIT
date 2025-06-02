<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StaffOrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('town_city', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('staff.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $users = User::all();
        $products = Product::where('stock', '>', 0)->get();
        return view('staff.orders.create', compact('users', 'products'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        // Validate order data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'first_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'town_city' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        // Calculate total
        $total = 0;
        foreach ($request->items as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        // Create the order
        $order = Order::create([
            'user_id' => $validated['user_id'],
            'first_name' => $validated['first_name'],
            'company_name' => $validated['company_name'] ?? null,
            'street_address' => $validated['street_address'],
            'apartment' => $validated['apartment'] ?? null,
            'town_city' => $validated['town_city'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'payment_method' => $validated['payment_method'],
            'total' => $total,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Create order items
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);

            // Update product stock
            $product = Product::find($item['product_id']);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        return redirect()->route('staff.orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('staff.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        $order->load(['items.product']);
        $users = User::all();
        $products = Product::all();
        return view('staff.orders.edit', compact('order', 'users', 'products'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order)
    {
        // Validate order data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'town_city' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Update the order
        $order->update([
            'first_name' => $validated['first_name'],
            'company_name' => $validated['company_name'] ?? null,
            'street_address' => $validated['street_address'],
            'apartment' => $validated['apartment'] ?? null,
            'town_city' => $validated['town_city'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'payment_method' => $validated['payment_method'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('staff.orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        // Delete order items first
        $order->items()->delete();

        // Delete the order
        $order->delete();

        return redirect()->route('staff.orders.index')->with('success', 'Order deleted successfully.');
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Print order receipt/invoice
     */
    public function print(Order $order)
    {
        $order->load(['user', 'items.product']);

        $pdf = Pdf::loadView('staff.orders.pdf', compact('order'));

        $filename = 'order_' . $order->id . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }
}