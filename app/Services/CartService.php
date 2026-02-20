<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartService
{
    public function getOrCreateCart(Request $request): Cart
    {
        $userId = auth()->id();

        if ($userId) {
            return Cart::firstOrCreate(['user_id' => $userId]);
        }

        $sessionId = $request->session()->get('cart_session_id');

        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            $request->session()->put('cart_session_id', $sessionId);
        }

        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    public function addItem(Cart $cart, Product $product, int $qty = 1): CartItem
    {
        $existing = $cart->items()->where('product_id', $product->id)->first();

        if ($existing) {
            $newQty = min($existing->qty + $qty, $product->stock_quantity);
            $existing->update(['qty' => $newQty, 'price_snapshot' => $product->price]);
            return $existing;
        }

        return $cart->items()->create([
            'product_id' => $product->id,
            'qty' => min($qty, $product->stock_quantity),
            'price_snapshot' => $product->price,
        ]);
    }

    public function updateItem(CartItem $item, int $qty): void
    {
        if ($qty <= 0) {
            $item->delete();
            return;
        }

        $item->update([
            'qty' => min($qty, $item->product->stock_quantity),
        ]);
    }

    public function removeItem(CartItem $item): void
    {
        $item->delete();
    }

    public function clearCart(Cart $cart): void
    {
        $cart->items()->delete();
    }

    public function getCartTotals(Cart $cart): array
    {
        $cart->load('items.product');
        $subtotal = $cart->items->sum(fn($i) => $i->price_snapshot * $i->qty);
        $deliveryFee = (float) \App\Models\Setting::get('delivery_fee', 0);

        return [
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'total' => $subtotal + $deliveryFee,
            'item_count' => $cart->items->sum('qty'),
        ];
    }

    public function mergeGuestCart(Request $request, int $userId): void
    {
        $sessionId = $request->session()->get('cart_session_id');
        if (!$sessionId)
            return;

        $guestCart = Cart::where('session_id', $sessionId)->first();
        if (!$guestCart)
            return;

        $userCart = Cart::firstOrCreate(['user_id' => $userId]);

        foreach ($guestCart->items as $guestItem) {
            $existing = $userCart->items()->where('product_id', $guestItem->product_id)->first();
            if ($existing) {
                $existing->update(['qty' => $existing->qty + $guestItem->qty]);
            } else {
                $userCart->items()->create([
                    'product_id' => $guestItem->product_id,
                    'qty' => $guestItem->qty,
                    'price_snapshot' => $guestItem->price_snapshot,
                ]);
            }
        }

        $guestCart->delete();
        $request->session()->forget('cart_session_id');
    }
}
