<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\PromoBanner;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 'active')
            ->withCount(['activeProducts'])
            ->orderBy('name')
            ->get();

        $featured = Product::active()
            ->featured()
            ->with(['primaryImage', 'category'])
            ->limit(8)
            ->get();

        // Trending: most recently added active products not in featured
        $trending = Product::active()
            ->with(['primaryImage', 'category'])
            ->whereNotIn('id', $featured->pluck('id'))
            ->latest()
            ->limit(10)
            ->get();

        $latest = Product::active()
            ->with(['primaryImage', 'category'])
            ->whereNotIn('id', $featured->pluck('id')->merge($trending->pluck('id')))
            ->latest()
            ->limit(10)
            ->get();

        // Promo banners grouped by grid position
        $promos2col = PromoBanner::active()->position('2col')->get();
        $promos3col = PromoBanner::active()->position('3col')->get();

        return view('home', compact(
            'categories',
            'featured',
            'trending',
            'latest',
            'promos2col',
            'promos3col'
        ));
    }
}
