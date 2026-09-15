<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'guest_email',
        'guest_phone',
        'status',
        'payment_status',
        'payment_method',
        'subtotal',
        'discount_amount',
        'coupon_code',
        'shipping_amount',
        'tax_amount',
        'total_amount',
        'shipping_name',
        'shipping_phone',
        'shipping_email',
        'shipping_address_line1',
        'shipping_address_line2',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',
        'notes',
        'admin_notes',
        'is_manual',
        'cancelled_at',
        'refunded_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'shipping_amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'is_manual' => 'boolean',
            'cancelled_at' => 'datetime',
            'refunded_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class)->latestOfMany();
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Scopes
    public function scopePaid(Builder $query): Builder
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotIn('status', ['cancelled', 'refunded']);
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Helpers
    public function getGrandTotalAttribute(): float
    {
        return (float) ($this->total_amount ?? 0);
    }

    public function getCustomerNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->name;
        }
        return $this->shipping_name ?: 'Guest Customer';
    }

    public function getCustomerEmailAttribute(): string
    {
        if ($this->user) {
            return $this->user->email;
        }
        return $this->guest_email ?: $this->shipping_email ?: 'N/A';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-100 text-amber-800 border-amber-300',
            'confirmed' => 'bg-blue-100 text-blue-800 border-blue-300',
            'processing' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
            'packed' => 'bg-purple-100 text-purple-800 border-purple-300',
            'shipped' => 'bg-cyan-100 text-cyan-800 border-cyan-300',
            'out_for_delivery' => 'bg-teal-100 text-teal-800 border-teal-300',
            'delivered' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'cancelled' => 'bg-rose-100 text-rose-800 border-rose-300',
            'returned', 'refunded' => 'bg-gray-100 text-gray-800 border-gray-300',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    public function getPaymentBadgeClassAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'pending' => 'bg-amber-100 text-amber-800 border-amber-300',
            'failed' => 'bg-rose-100 text-rose-800 border-rose-300',
            'refunded' => 'bg-purple-100 text-purple-800 border-purple-300',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }
}
