<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
            MenuSeeder::class,
            ThemePresetSeeder::class,
                // Shop data
            CategorySeeder::class,
            ProductSeeder::class,
            PromoBannerSeeder::class,
        ]);
    }
}
