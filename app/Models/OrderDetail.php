<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    protected $fillable = [
        'sale_order_id',
        'product_id',
        'quantity',
        'price',
        'discount',
        'total',
    ];

    public function saleOrder()
    {
        return $this->belongsTo(Order::class, 'sale_order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
