<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::create([
            'title' => 'About Us',
            'slug' => 'about-us',
            'content' => '<h1>About Us</h1><p>Welcome to our store. We are dedicated to providing the best products and service.</p>',
            'is_active' => true,
        ]);

        Page::create([
            'title' => 'Contact Us',
            'slug' => 'contact-us',
            'content' => '<h1>Contact Us</h1><p>Feel free to reach out to us at support@example.com.</p>',
            'is_active' => true,
        ]);
        
        Page::create([
            'title' => 'Privacy Policy',
            'slug' => 'privacy-policy',
            'content' => '<h1>Privacy Policy</h1><p>Your privacy is important to us.</p>',
            'is_active' => true,
        ]);

        Page::create([
            'title' => 'Terms & Conditions',
            'slug' => 'terms-conditions',
            'content' => '<h1>Terms & Conditions</h1><p>Please read our terms carefully.</p>',
            'is_active' => true,
        ]);
    }
}
