<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function orders(Request $request)
    {
        $query = Order::with('orderDetails'); // Thêm eager loading
    
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }
    
        if ($request->filled('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
    
        $orders = $query->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'status' => 'required|in:1,2,3,4',
            'total_price' => 'required|numeric|min:0',
            'custom_order_number' => 'required|integer|min:1|max:999',
        ]);

        $today = date('Ymd');
        $customNumber = str_pad($request->custom_order_number, 3, '0', STR_PAD_LEFT);
        $newOrderCode = 'ORD-' . $today . '-' . $customNumber;

        $order = Order::create([
            'order_code' => $newOrderCode, // Đổi order_id thành order_code
            'customer_name' => $request->customer_name,
            'status' => (int)$request->status,
            'total_price' => $request->total_price,
        ]);

        return redirect()->route('admin.orders')->with('success', "Đơn hàng {$newOrderCode} đã được thêm!");
    }




    public function createOrder()
    {
        return view('admin.orders-create'); // Đảm bảo có file này trong thư mục views
    }

    public function editOrder($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders-edit', compact('order'));
    }

    public function updateOrder(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'status' => 'required|in:1,2,3,4',
            'total_price' => 'required|numeric|min:0',
        ]);
    
        $order = Order::findOrFail($id);
        $today = Carbon::now()->format('Ymd');
    
        // Lấy số lượng đơn hàng đã có trong ngày để tạo mã mới
        $orderCount = Order::where('order_code', 'LIKE', "ORD-$today-%")->count() + 1;
        $customNumber = str_pad($orderCount, 3, '0', STR_PAD_LEFT);
        $newOrderCode = "ORD-$today-$customNumber";
    
        // Đảm bảo không có mã trùng
        while (Order::where('order_code', $newOrderCode)->exists()) {
            $orderCount++;
            $customNumber = str_pad($orderCount, 3, '0', STR_PAD_LEFT);
            $newOrderCode = "ORD-$today-$customNumber";
        }
    
        $order->update([
            'order_code' => $newOrderCode,
            'customer_name' => $request->customer_name,
            'status' => (int) $request->status,
            'total_price' => $request->total_price,
        ]);
    
        return redirect()->route('admin.orders')->with('success', "Đơn hàng {$newOrderCode} đã được cập nhật!");
    }
    



    public function destroyOrder($id)
    {
        $order = Order::with('orderDetails')->find($id);

        if (!$order) {
            return redirect()->route('admin.orders')->with('error', 'Order not found!');
        }

        $order->delete();

        return redirect()->route('admin.orders')->with('success', 'Order deleted successfully!');
    }

}
