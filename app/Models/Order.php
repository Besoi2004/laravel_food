<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code', // Đổi order_id thành order_code
        'customer_name',
        'status',
        'total_price'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($order) {
            $order->orderDetails()->delete();
        });
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}

