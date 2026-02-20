<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {
    }

    public function index(Request $request)
    {
        $cart = $this->cartService->getOrCreateCart($request);
        $cart->load('items.product.primaryImage');
        $totals = $this->cartService->getCartTotals($cart);

        return view('shop.cart', compact('cart', 'totals'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'nullable|integer|min:1|max:100',
        ]);

        $product = Product::active()->findOrFail($request->product_id);

        if (!$product->isInStock()) {
            return back()->with('error', 'Sorry, this product is out of stock.');
        }

        $cart = $this->cartService->getOrCreateCart($request);
        $this->cartService->addItem($cart, $product, $request->input('qty', 1));

        if ($request->expectsJson()) {
            $totals = $this->cartService->getCartTotals($cart->fresh(['items']));
            return response()->json([
                'success' => true,
                'cart_count' => $totals['item_count'],
                'cart_total' => number_format($totals['total'], 2)
            ]);
        }

        return back()->with('success', "'{$product->name}' added to cart!");
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|integer',
            'qty' => 'required|integer|min:0|max:100',
        ]);

        $cart = $this->cartService->getOrCreateCart($request);
        $item = $cart->items()->findOrFail($request->cart_item_id);
        $this->cartService->updateItem($item, $request->qty);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request)
    {
        $request->validate(['cart_item_id' => 'required|integer']);
        $cart = $this->cartService->getOrCreateCart($request);
        $item = $cart->items()->findOrFail($request->cart_item_id);
        $this->cartService->removeItem($item);

        return back()->with('success', 'Item removed from cart.');
    }
}
