<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'old_price',
        'short_description',
        'long_description',
        'description',
        'status',
        'stock_quantity',
        'low_stock_threshold',
        'is_featured',
        'colors',
        'sizes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'stock_quantity' => 'integer',
        'low_stock_threshold' => 'integer',
        'colors' => 'array',
        'sizes' => 'array',
    ];

    /* ── Relationships ─────────────────────────────────────── */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->orderBy('sort_order');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /* ── Scopes ────────────────────────────────────────────── */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /* ── Helpers ───────────────────────────────────────────── */

    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function isLowStock(): bool
    {
        if ($this->low_stock_threshold === null)
            return false;
        return $this->stock_quantity <= $this->low_stock_threshold && $this->stock_quantity > 0;
    }

    public function hasColors(): bool
    {
        return !empty($this->colors);
    }

    public function hasSizes(): bool
    {
        return !empty($this->sizes);
    }

    public function discountPercent(): ?int
    {
        if (!$this->old_price || $this->old_price <= $this->price)
            return null;
        return (int) round((($this->old_price - $this->price) / $this->old_price) * 100);
    }

    public static function generateSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $count = 1;
        while (
            self::where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = "{$original}-{$count}";
            $count++;
        }
        return $slug;
    }
}
