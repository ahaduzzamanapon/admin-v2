<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopCategoryController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $query = $category->activeProducts()->with(['primaryImage']);

        // Sort
        match ($request->get('sort', 'latest')) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name_asc' => $query->orderBy('name'),
            default => $query->orderByDesc('created_at'),
        };

        $products = $query->paginate(16)->withQueryString();
        $categories = Category::where('status', 'active')->get();

        return view('shop.category', compact('category', 'products', 'categories'));
    }
}
