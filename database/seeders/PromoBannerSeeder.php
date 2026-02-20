<?php

namespace Database\Seeders;

use App\Models\PromoBanner;
use Illuminate\Database\Seeder;

class PromoBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            // ── 2-column top row ────────────────────────────────
            [
                'position' => '2col',
                'sort_order' => 1,
                'tag' => 'Special Offer',
                'title' => "Laptops\nUp to 20% OFF",
                'subtitle' => 'Limited stock available',
                'icon' => 'fa-laptop',
                'color_from' => '#1a3a6e',
                'color_to' => '#2563eb',
                'link_label' => 'Shop Now',
                'link_type' => 'category',
                'link_value' => 'laptops',
            ],
            [
                'position' => '2col',
                'sort_order' => 2,
                'tag' => 'Best Sellers',
                'title' => "Audio Gear\nBest Prices",
                'subtitle' => 'Headphones, speakers & earbuds',
                'icon' => 'fa-headphones',
                'color_from' => '#0f2027',
                'color_to' => '#203a43',
                'link_label' => 'Shop Now',
                'link_type' => 'category',
                'link_value' => 'sound-system',
            ],

            // ── 3-column bottom row ──────────────────────────────
            [
                'position' => '3col',
                'sort_order' => 1,
                'tag' => 'Weekend Deal',
                'title' => 'Gaming Accessories',
                'subtitle' => 'Up to 40% off this weekend only',
                'icon' => 'fa-gamepad',
                'color_from' => '#7c3aed',
                'color_to' => '#5b21b6',
                'link_label' => 'Explore',
                'link_type' => 'category',
                'link_value' => 'gaming-accessories',
            ],
            [
                'position' => '3col',
                'sort_order' => 2,
                'tag' => 'Top Picks',
                'title' => 'Desktop & PC',
                'subtitle' => 'Premium components & peripherals',
                'icon' => 'fa-desktop',
                'color_from' => '#0891b2',
                'color_to' => '#0e7490',
                'link_label' => 'Explore',
                'link_type' => 'category',
                'link_value' => 'desktop-pc-accessories',
            ],
            [
                'position' => '3col',
                'sort_order' => 3,
                'tag' => 'Home Essentials',
                'title' => 'Household Appliances',
                'subtitle' => 'Make life easier at home',
                'icon' => 'fa-blender',
                'color_from' => '#d97706',
                'color_to' => '#b45309',
                'link_label' => 'Explore',
                'link_type' => 'category',
                'link_value' => 'household-appliances',
            ],
        ];

        foreach ($banners as $data) {
            PromoBanner::firstOrCreate(
                ['title' => $data['title'], 'position' => $data['position']],
                $data
            );
        }
    }
}
