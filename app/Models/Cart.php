<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'session_id'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalAttribute(): float
    {
        return $this->items->sum(fn($item) => $item->price_snapshot * $item->qty);
    }

    public function getTotalItemsAttribute(): int
    {
        return $this->items->sum('qty');
    }
}
