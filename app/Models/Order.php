<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'payment_method',
        'payment_status',
        'subtotal',
        'delivery_fee',
        'total',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    const STATUSES = [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'packed' => 'Packed',
        'out_for_delivery' => 'Out for Delivery',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled',
        'returned' => 'Returned',
    ];

    const STATUS_COLORS = [
        'pending' => 'warning',
        'confirmed' => 'info',
        'packed' => 'primary',
        'out_for_delivery' => 'secondary',
        'delivered' => 'success',
        'cancelled' => 'danger',
        'returned' => 'dark',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'secondary';
    }

    public function isStockDeducted(): bool
    {
        return in_array($this->status, ['confirmed', 'packed', 'out_for_delivery', 'delivered']);
    }

    public function isCancellable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed', 'packed']);
    }
}
