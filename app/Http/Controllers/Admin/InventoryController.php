<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function __construct(private InventoryService $inventory)
    {
    }

    public function index(Request $request)
    {
        $query = Product::with(['category', 'primaryImage'])->orderBy('stock_quantity');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(20)->withQueryString();
        $lowStock = $this->inventory->getLowStockProducts();

        return view('admin.inventory.index', compact('products', 'lowStock'));
    }

    public function adjust(Request $request, Product $product)
    {
        $request->validate([
            'adjustment' => 'required|integer',
            'reason' => 'nullable|string|max:255',
        ]);

        $this->inventory->adjustStock($product, $request->adjustment, $request->reason ?? '');

        return back()->with('success', "Stock adjusted by {$request->adjustment} for '{$product->name}'.");
    }
}
