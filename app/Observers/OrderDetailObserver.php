<?php

namespace App\Observers;

use App\Models\OrderDetail;

class OrderDetailObserver
{
    public function created(OrderDetail $orderDetail)
    {
        $this->updateOrderTotal($orderDetail);
    }

    public function updated(OrderDetail $orderDetail)
    {
        $this->updateOrderTotal($orderDetail);
    }

    public function deleted(OrderDetail $orderDetail)
    {
        $this->updateOrderTotal($orderDetail);
    }

    private function updateOrderTotal(OrderDetail $orderDetail)
    {
        $order = $orderDetail->order;
        $total = $order->orderDetails->sum(function($detail) {
            return $detail->price * $detail->quantity;
        });
        $order->update(['total_price' => $total]);
    }
}