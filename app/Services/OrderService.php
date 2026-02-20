<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(private InventoryService $inventory)
    {
    }

    public function createFromCart(Cart $cart, array $shippingData): Order
    {
        $cart->load('items.product');

        // Validate stock before creating
        foreach ($cart->items as $item) {
            if (!$item->product || $item->product->stock_quantity < $item->qty) {
                throw new \Exception("'{$item->product?->name}' does not have enough stock.");
            }
        }

        $deliveryFee = (float) \App\Models\Setting::get('delivery_fee', 0);
        $subtotal = $cart->items->sum(fn($i) => $i->price_snapshot * $i->qty);
        $total = $subtotal + $deliveryFee;

        return DB::transaction(function () use ($cart, $shippingData, $subtotal, $deliveryFee, $total) {
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => $cart->user_id,
                'status' => 'pending',
                'payment_method' => 'COD',
                'payment_status' => 'unpaid',
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'shipping_name' => $shippingData['shipping_name'],
                'shipping_phone' => $shippingData['shipping_phone'],
                'shipping_address' => $shippingData['shipping_address'],
                'shipping_city' => $shippingData['shipping_city'],
                'notes' => $shippingData['notes'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name_snapshot' => $item->product->name,
                    'price_snapshot' => $item->price_snapshot,
                    'qty' => $item->qty,
                    'line_total' => $item->price_snapshot * $item->qty,
                ]);
            }

            // Clear the cart
            $cart->items()->delete();

            return $order;
        });
    }

    public function updateStatus(Order $order, string $newStatus): void
    {
        $old = $order->status;

        DB::transaction(function () use ($order, $old, $newStatus) {
            // Deduct stock when confirming
            if ($newStatus === 'confirmed' && !$order->isStockDeducted()) {
                $this->inventory->deductStock($order);
            }

            // Restore stock when cancelling after stock was deducted
            if ($newStatus === 'cancelled' && $order->isStockDeducted()) {
                $this->inventory->restoreStock($order);
            }

            // Mark paid when delivered
            if ($newStatus === 'delivered') {
                $order->payment_status = 'paid';
            }

            $order->status = $newStatus;
            $order->save();
        });
    }

    public function cancelOrder(Order $order): void
    {
        if (!$order->isCancellable()) {
            throw new \Exception('This order cannot be cancelled.');
        }
        $this->updateStatus($order, 'cancelled');
    }

    public function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(5));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
