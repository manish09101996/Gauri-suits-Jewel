<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'customer_name',
        'customer_email',
        'rating',
        'title',
        'comment',
        'status',
        'is_verified_purchase',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_verified_purchase' => 'boolean',
            'approved_at' => 'datetime',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function getAuthorNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->name;
        }
        return $this->customer_name ?: 'Customer';
    }
}
