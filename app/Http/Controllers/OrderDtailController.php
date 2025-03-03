<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;

class OrderDtailController extends Controller
{
    public function orderDetails(Request $request)
    {
        $query = OrderDetail::with(['order', 'menu']);
    
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                // Search in menu names
                $q->whereHas('menu', function($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                // OR search in order codes
                ->orWhereHas('order', function($query) use ($search) {
                    $query->where('order_code', 'like', "%{$search}%");
                });
            });
        }
    
        $orderDetails = $query->latest()->get();
        return view('admin.order-details', compact('orderDetails'));
    }
    public function getTotalFromDetailsAttribute()
    {
        $orderDetails = OrderDetail::all();
        return $orderDetails->sum(function($detail) {
            return $detail->price * $detail->quantity;
        });
    }

    public function showOrderDetail($id)
    {
        $orderDetail = OrderDetail::with(['order', 'menu'])->findOrFail($id);
        return view('admin.order-details.show', compact('orderDetail'));
    }

    public function createOrderDetail()
    {
        $orders = Order::all();
        $menus = Menu::all();
        return view('admin.order-details-create', compact('orders', 'menus'));
    }

    public function storeOrderDetail(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        OrderDetail::create([
            'order_id' => $request->order_id,
            'menu_id' => $request->menu_id,
            'quantity' => $request->quantity,
            'price' => $request->price
        ]);

        return redirect()->route('admin.order-details')->with('success', 'Order detail created successfully!');
    }

    public function editOrderDetail($id)
    {
        $orderDetail = OrderDetail::findOrFail($id);
        $orders = Order::all();
        $menus = Menu::all();
        return view('admin.order-details-edit', compact('orderDetail', 'orders', 'menus'));
    }

    public function updateOrderDetail(Request $request, $id)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        $orderDetail = OrderDetail::findOrFail($id);
        $orderDetail->update($request->all());

        return redirect()->route('admin.order-details')->with('success', 'Order detail updated successfully!');
    }

    public function destroyOrderDetail($id)
    {
        try {
            $orderDetail = OrderDetail::findOrFail($id);
            $orderDetail->delete();
            
            return redirect()
                ->route('admin.order-details')
                ->with('success', 'Order detail deleted successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.order-details')
                ->with('error', 'Error deleting order detail');
        }
    }
}
