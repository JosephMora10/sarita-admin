<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailySaleDetail extends Model
{
    protected $table = 'daily_sale_details';

    protected $fillable = [
        'daily_sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function dailySale(): BelongsTo
    {
        return $this->belongsTo(DailySale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
