<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService
    ) {
    }

    public function index(Request $request)
    {
        $cart = $this->cartService->getOrCreateCart($request);
        $cart->load('items.product.primaryImage');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $totals = $this->cartService->getCartTotals($cart);
        $user = auth()->user();

        return view('shop.checkout', compact('cart', 'totals', 'user'));
    }

    public function place(Request $request)
    {
        $data = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = $this->cartService->getOrCreateCart($request);
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        try {
            $order = $this->orderService->createFromCart($cart, $data);
            return redirect()->route('order.confirmation', $order->order_number);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function confirmation(string $orderNumber)
    {
        $order = \App\Models\Order::where('order_number', $orderNumber)
            ->with(['items.product'])
            ->firstOrFail();

        return view('shop.order_confirmation', compact('order'));
    }
}
