<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Laptops', 'icon' => 'fa-laptop', 'description' => 'Notebooks and laptops for every need.'],
            ['name' => 'Smartphones', 'icon' => 'fa-mobile-screen', 'description' => 'Latest smartphones and mobile devices.'],
            ['name' => 'TVs & Monitors', 'icon' => 'fa-tv', 'description' => 'Smart TVs and computer monitors.'],
            ['name' => 'Gaming Accessories', 'icon' => 'fa-gamepad', 'description' => 'Controllers, headsets, and more.'],
            ['name' => 'Sound System', 'icon' => 'fa-music', 'description' => 'Speakers, headphones, earphones.'],
            ['name' => 'Office Equipment', 'icon' => 'fa-briefcase', 'description' => 'Printers, scanners, and office gear.'],
            ['name' => 'Household Appliances', 'icon' => 'fa-blender', 'description' => 'Kitchen and home appliances.'],
            ['name' => 'Software', 'icon' => 'fa-floppy-disk', 'description' => 'Software licenses and subscriptions.'],
            ['name' => 'Desktop PC & Accessories', 'icon' => 'fa-desktop', 'description' => 'Desktops, keyboards, mice and more.'],
            ['name' => 'Kitchen Appliances', 'icon' => 'fa-kitchen-set', 'description' => 'Appliances for your kitchen.'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name']],
                [
                    'slug' => \Illuminate\Support\Str::slug($cat['name']),
                    'description' => $cat['description'],
                    'icon' => $cat['icon'],
                    'status' => 'active',
                ]
            );
        }
    }
}
