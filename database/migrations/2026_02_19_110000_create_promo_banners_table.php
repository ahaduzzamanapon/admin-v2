<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('promo_banners', function (Blueprint $table) {
            $table->id();
            $table->string('tag');           // e.g. "Special Offer"
            $table->string('title');         // e.g. "Laptops Up to 20% OFF"
            $table->string('subtitle')->nullable();
            $table->string('icon')->default('fa-star');      // FontAwesome class
            $table->string('color_from')->default('#1a3a6e'); // gradient start
            $table->string('color_to')->default('#2563eb');   // gradient end
            $table->string('link_label')->default('Shop Now'); // button text
            $table->string('link_type')->default('category'); // 'category' | 'url'
            $table->string('link_value');    // category slug or full URL
            $table->enum('position', ['2col', '3col'])->default('2col');  // which grid
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_banners');
    }
};
