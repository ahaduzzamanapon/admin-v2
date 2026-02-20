<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class InventoryService
{
    public function deductStock(Order $order): void
    {
        foreach ($order->items as $item) {
            if ($item->product_id) {
                Product::where('id', $item->product_id)
                    ->decrement('stock_quantity', $item->qty);
            }
        }
    }

    public function restoreStock(Order $order): void
    {
        foreach ($order->items as $item) {
            if ($item->product_id) {
                Product::where('id', $item->product_id)
                    ->increment('stock_quantity', $item->qty);
            }
        }
    }

    public function getLowStockProducts(int $defaultThreshold = 5)
    {
        return Product::active()
            ->where(function ($q) use ($defaultThreshold) {
                $q->whereRaw('stock_quantity <= COALESCE(low_stock_threshold, ?)', [$defaultThreshold])
                    ->where('stock_quantity', '>', 0);
            })
            ->with('primaryImage')
            ->orderBy('stock_quantity')
            ->get();
    }

    public function adjustStock(Product $product, int $adjustment, string $reason = ''): void
    {
        $product->increment('stock_quantity', $adjustment);
    }
}
