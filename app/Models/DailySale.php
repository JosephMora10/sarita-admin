<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DailySale extends Model
{
    protected $table = 'daily_sales';

    protected $fillable = [
        'items_qty',
        'total_amount',
        'seller_id',
        'is_completed',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'total_amount' => 'decimal:2',
        'is_completed' => 'boolean',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(DailySaleDetail::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function calculateTotal(): float
    {
        return $this->details->sum('subtotal');
    }
}
