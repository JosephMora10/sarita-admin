<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'items_qty',
        'sub_total',
        'discount',
        'total',
        'payment_method_id',
        'seller_id',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'sale_order_id');
    }
}
