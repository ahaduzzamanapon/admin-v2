<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('primaryImage', 'category')->paginate(12);
        return view('shop.wishlist', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $user = Auth::user();
        $productId = $request->product_id;

        // Toggle attachment
        $attached = $user->favorites()->toggle($productId);

        // Check if attached or detached to return status
        $isFavorited = count($attached['attached']) > 0;

        return response()->json([
            'status' => 'success',
            'is_favorited' => $isFavorited,
            'message' => $isFavorited ? 'Product added to wishlist' : 'Product removed from wishlist',
            'count' => $user->favorites()->count()
        ]);
    }
}
