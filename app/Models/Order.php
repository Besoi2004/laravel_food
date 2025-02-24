<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'customer_name', 
        'status',
        'total_price'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Thêm accessor để tính tổng tiền
    public function getTotalFromDetailsAttribute()
    {
        return $this->orderDetails->sum(function($detail) {
            return $detail->price * $detail->quantity;
        });
    }
}
