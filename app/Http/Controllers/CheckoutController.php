<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page
     */
    public function index()
    {
        // Get cart items for the current user
        $cartItems = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        // Calculate total
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Process the checkout
     */
    public function process(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'town_city' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'payment_method' => 'required|in:bank,cash',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get cart items
        $cartItems = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')  // Changed from 'cart' to 'cart.index'
                ->with('error', 'Your cart is empty.');
        }

        // Calculate total
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'first_name' => $request->first_name,
                'company_name' => $request->company_name,
                'street_address' => $request->street_address,
                'apartment' => $request->apartment,
                'town_city' => $request->town_city,
                'phone' => $request->phone,
                'email' => $request->email,
                'payment_method' => $request->payment_method,
                'total' => $total,
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            // Save billing information if requested
            if ($request->has('save_info') && $request->save_info) {
                auth()->user()->update([
                    'first_name' => $request->first_name,
                    'street_address' => $request->street_address,
                    'town_city' => $request->town_city,
                    'phone' => $request->phone,
                ]);
            }

            // Clear cart
            CartItem::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('checkout.success', ['order' => $order->id])
                ->with('success', 'Your order has been placed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'An error occurred while processing your order. Please try again.')
                ->withInput();
        }
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Coupon functionality is not available.'
        ]);
    }

    /**
     * Display checkout success page
     */
    public function success($orderId)
    {
        $order = Order::with(['items.product'])->findOrFail($orderId);

        // Ensure the order belongs to the current user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }
    /**
     * Generate and download order PDF
     */
    public function downloadPdf($orderId)
    {
        $order = Order::with(['items.product'])->findOrFail($orderId);

        // Ensure the order belongs to the current user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = PDF::loadView('checkout.pdf', compact('order'));

        return $pdf->download('order-' . $order->id . '.pdf');
    }
}