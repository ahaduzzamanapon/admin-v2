<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Laptops
            [
                'name' => 'ProBook Ultra 15 Laptop',
                'category' => 'Laptops',
                'price' => 75000,
                'old_price' => 85000,
                'stock' => 12,
                'featured' => true,
                'desc' => 'Intel Core i7 12th Gen, 16GB DDR5 RAM, 512GB NVMe SSD, 15.6" Full HD IPS display (300 nit, 144Hz). Thunderbolt 4, Wi-Fi 6E, backlit keyboard. Ideal for professionals and creators.',
                'colors' => ['Space Grey', 'Silver', 'Midnight Black'],
                'sizes' => [],
                'images' => [
                    'https://picsum.photos/seed/laptop1a/600/600',
                    'https://picsum.photos/seed/laptop1b/600/600',
                    'https://picsum.photos/seed/laptop1c/600/600',
                ],
            ],
            [
                'name' => 'SlimBook Air 13 Pro',
                'category' => 'Laptops',
                'price' => 62000,
                'old_price' => null,
                'stock' => 7,
                'featured' => true,
                'desc' => 'Ultra-thin 13.3" laptop with Core i5 11th Gen, 8GB LPDDR5 RAM, 256GB SSD. Weighs only 1.1 kg. Perfect for students and on-the-go professionals.',
                'colors' => ['Rose Gold', 'Silver'],
                'sizes' => [],
                'images' => [
                    'https://picsum.photos/seed/laptop2a/600/600',
                    'https://picsum.photos/seed/laptop2b/600/600',
                ],
            ],
            [
                'name' => 'Gaming Beast X Pro Laptop',
                'category' => 'Laptops',
                'price' => 120000,
                'old_price' => 135000,
                'stock' => 4,
                'featured' => false,
                'desc' => 'RTX 4060 8GB, Intel Core i9-13900HX, 32GB DDR5, 1TB PCIe 4.0 NVMe, 165Hz QHD display with G-Sync. Dominate every game at ultra settings.',
                'colors' => ['Stealth Black'],
                'sizes' => [],
                'images' => [
                    'https://picsum.photos/seed/laptop3a/600/600',
                    'https://picsum.photos/seed/laptop3b/600/600',
                ],
            ],

            // Smartphones
            [
                'name' => 'Galaxy Z Pro 5G',
                'category' => 'Smartphones',
                'price' => 45000,
                'old_price' => 52000,
                'stock' => 20,
                'featured' => true,
                'desc' => '6.7" Super AMOLED 120Hz display, 108MP Quad-camera system, 5000mAh battery with 65W fast charging. 5G capable. IP68 water resistant.',
                'colors' => ['Phantom Black', 'Cream White', 'Lavender'],
                'sizes' => ['128GB', '256GB'],
                'images' => [
                    'https://picsum.photos/seed/phone1a/600/600',
                    'https://picsum.photos/seed/phone1b/600/600',
                    'https://picsum.photos/seed/phone1c/600/600',
                    'https://picsum.photos/seed/phone1d/600/600',
                ],
            ],
            [
                'name' => 'iPhone MaxPro 15',
                'category' => 'Smartphones',
                'price' => 130000,
                'old_price' => null,
                'stock' => 9,
                'featured' => true,
                'desc' => 'A17 Pro Bionic chip, Pro camera system with 48MP main, 5x optical zoom, Titanium design, Action Button, USB-C with USB 3 speeds. iOS 17.',
                'colors' => ['Natural Titanium', 'Blue Titanium', 'White Titanium', 'Black Titanium'],
                'sizes' => ['256GB', '512GB', '1TB'],
                'images' => [
                    'https://picsum.photos/seed/phone2a/600/600',
                    'https://picsum.photos/seed/phone2b/600/600',
                    'https://picsum.photos/seed/phone2c/600/600',
                ],
            ],
            [
                'name' => 'BudgetKing Note 12',
                'category' => 'Smartphones',
                'price' => 18000,
                'old_price' => 22000,
                'stock' => 35,
                'featured' => false,
                'desc' => '6.5" IPS LCD display, 50MP triple camera, Helio G99 processor, 5000mAh battery, 33W fast charging. Best value smartphone for everyday use.',
                'colors' => ['Forest Green', 'Sky Blue', 'Matte Black'],
                'sizes' => ['64GB', '128GB'],
                'images' => [
                    'https://picsum.photos/seed/phone3a/600/600',
                    'https://picsum.photos/seed/phone3b/600/600',
                ],
            ],

            // TVs
            [
                'name' => '55" 4K OLED Smart TV',
                'category' => 'TVs & Monitors',
                'price' => 85000,
                'old_price' => 98000,
                'stock' => 5,
                'featured' => true,
                'desc' => 'OLED evo panel with 4K resolution, 120Hz, HFR, Dolby Vision IQ & Atmos. Built-in Google TV, AI Picture Pro. Ideal for cinematic viewing.',
                'colors' => ['Black'],
                'sizes' => [],
                'images' => [
                    'https://picsum.photos/seed/tv1a/600/600',
                    'https://picsum.photos/seed/tv1b/600/600',
                ],
            ],
            [
                'name' => '65" QLED Crystal 4K TV',
                'category' => 'TVs & Monitors',
                'price' => 110000,
                'old_price' => 125000,
                'stock' => 3,
                'featured' => true,
                'desc' => 'Quantum Dot 4K, 144Hz, HDR10+, Motion Xcelerator Turbo+, built-in Tizen smart platform with One Remote Control.',
                'colors' => ['Black'],
                'sizes' => [],
                'images' => [
                    'https://picsum.photos/seed/tv2a/600/600',
                    'https://picsum.photos/seed/tv2b/600/600',
                ],
            ],

            // Gaming
            [
                'name' => 'Mechanical RGB Gaming Keyboard',
                'category' => 'Gaming Accessories',
                'price' => 5500,
                'old_price' => 7000,
                'stock' => 12,
                'featured' => true,
                'desc' => 'Full-size mechanical keyboard with genuine Cherry MX Red switches. Per-key RGB with 16.8M colors. N-key rollover, aluminum top frame, detachable cable.',
                'colors' => ['Black', 'White'],
                'sizes' => [],
                'images' => [
                    'https://picsum.photos/seed/gaming3a/600/600',
                    'https://picsum.photos/seed/gaming3b/600/600',
                    'https://picsum.photos/seed/gaming3c/600/600',
                ],
            ],
            [
                'name' => 'Pro Gaming Headset 7.1',
                'category' => 'Gaming Accessories',
                'price' => 4500,
                'old_price' => 6000,
                'stock' => 25,
                'featured' => false,
                'desc' => 'Virtual 7.1 surround sound, noise-cancelling flip mic, 50mm drivers, memory foam ear cushions. PC &amp; console compatible.',
                'colors' => ['Black/Red', 'Black/Blue'],
                'sizes' => [],
                'images' => [
                    'https://picsum.photos/seed/gaming1a/600/600',
                    'https://picsum.photos/seed/gaming1b/600/600',
                ],
            ],

            // Sound
            [
                'name' => 'NoiseX Pro ANC Headphones',
                'category' => 'Sound System',
                'price' => 8500,
                'old_price' => 11000,
                'stock' => 10,
                'featured' => true,
                'desc' => 'Industry-leading ANC cancels 99% of background noise. 40h battery life. Hi-Res Audio certified, Wear detection, premium protein leather ear cups.',
                'colors' => ['Midnight Black', 'Sand White', 'Indigo Blue'],
                'sizes' => [],
                'images' => [
                    'https://picsum.photos/seed/headphone1a/600/600',
                    'https://picsum.photos/seed/headphone1b/600/600',
                    'https://picsum.photos/seed/headphone1c/600/600',
                ],
            ],
            [
                'name' => 'True Wireless Earbuds Pro',
                'category' => 'Sound System',
                'price' => 2800,
                'old_price' => null,
                'stock' => 40,
                'featured' => false,
                'desc' => 'Hybrid ANC with 4-mic call system. 8h buds + 24h case battery. IPX5 sweat resistant. Instant pairing, equalizer app support.',
                'colors' => ['Glossy White', 'Matte Black'],
                'sizes' => [],
                'images' => [
                    'https://picsum.photos/seed/earbuds1a/600/600',
                    'https://picsum.photos/seed/earbuds1b/600/600',
                ],
            ],

            // Desktop
            [
                'name' => 'PowerDesk Pro i9 PC Tower',
                'category' => 'Desktop PC & Accessories',
                'price' => 95000,
                'old_price' => 108000,
                'stock' => 2,
                'featured' => true,
                'desc' => 'Intel Core i9-13900K, NVIDIA RTX 4070 12GB, 32GB DDR5 6000MHz, 2TB PCIe 4.0 NVMe, 850W 80+ Gold PSU. Water-cooled. Built for creators &amp; gamers.',
                'colors' => ['Tempered Glass Black'],
                'sizes' => [],
                'images' => [
                    'https://picsum.photos/seed/desktop1a/600/600',
                    'https://picsum.photos/seed/desktop1b/600/600',
                ],
            ],

            // Household
            [
                'name' => 'SmartCool Inverter AC 1.5 Ton',
                'category' => 'Household Appliances',
                'price' => 65000,
                'old_price' => 72000,
                'stock' => 5,
                'featured' => true,
                'desc' => '1.5 Ton Split Inverter AC. 5-Star BEE rating, Wi-Fi Smart control via app, Auto-clean, PM 2.5 filter, 4-way airflow, Silent mode (19dB).',
                'colors' => ['White'],
                'sizes' => ['1 Ton', '1.5 Ton', '2 Ton'],
                'images' => [
                    'https://picsum.photos/seed/ac1a/600/600',
                    'https://picsum.photos/seed/ac1b/600/600',
                ],
            ],
        ];

        foreach ($products as $p) {
            $category = Category::where('name', $p['category'])->first();
            if (!$category)
                continue;

            $slug = \App\Models\Product::generateSlug($p['name']);

            $product = Product::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $p['name'],
                    'description' => $p['desc'],
                    'short_description' => \Illuminate\Support\Str::limit(strip_tags($p['desc']), 120),
                    'price' => $p['price'],
                    'old_price' => $p['old_price'],
                    'stock_quantity' => $p['stock'],
                    'is_featured' => $p['featured'],
                    'category_id' => $category->id,
                    'status' => 'active',
                    'low_stock_threshold' => 5,
                    'colors' => !empty($p['colors']) ? $p['colors'] : null,
                    'sizes' => !empty($p['sizes']) ? $p['sizes'] : null,
                ]
            );

            // Add placeholder images
            if ($product->images()->count() === 0) {
                foreach ($p['images'] as $i => $url) {
                    $product->images()->create([
                        'path' => $url,
                        'is_primary' => $i === 0,
                        'sort_order' => $i,
                    ]);
                }
            }
        }
    }
}
