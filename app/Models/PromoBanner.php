<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoBanner extends Model
{
    protected $fillable = [
        'tag',
        'title',
        'subtitle',
        'icon',
        'color_from',
        'color_to',
        'link_label',
        'link_type',
        'link_value',
        'position',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /* ── Scopes ─────────────────────────────── */

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopePosition($query, string $position)
    {
        return $query->where('position', $position);
    }

    /* ── Helpers ────────────────────────────── */

    /**
     * Resolve the real URL for the banner's CTA button.
     */
    public function resolveUrl(): string
    {
        if ($this->link_type === 'category') {
            return route('shop.category', $this->link_value);
        }
        return $this->link_value ?: '#';
    }
}
