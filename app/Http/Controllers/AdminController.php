<?php

namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Menu;
    use App\Models\Order;
    use App\Models\OrderDetail;
    use Carbon\Carbon;




    class AdminController extends Controller
    {
        
        public function AdminDashboard()
        {
            return view('admin.index');
        }
        public function AdminLogout(Request $request)
        {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/login');
        }
        
        // In AdminController.php
        public function menus(Request $request)
        {
            $query = Menu::query();
        
            // Search by name
            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->where('name', 'like', "%{$search}%");
            }
        
            // Filter by category 
            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }
        
            $menus = $query->latest()->get(); // Thêm phân trang nếu muốn
            return view('admin.menus', compact('menus'));
        }

        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category' => 'required|integer',
        
            ]);
        
        
                Menu::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'price' => $request->price,
                    'category' => $request->category,
                    
                ]);
        
                return redirect()->route('admin.menus')->with('success', 'Dish added successfully!');
    }  

        
        public function create()
    {
        return view('admin.menus-create'); // Đảm bảo có file này trong thư mục views
    }

        

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menus-edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update($request->all());

        return redirect()->route('admin.menus')->with('success', 'Món ăn đã được cập nhật!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menus')->with('success', 'Món ăn đã được xóa!');
    }



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



    // Add this after the destroyOrder method and before the closing class brace

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
        return $this->orderDetails->sum(function($detail) {
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
