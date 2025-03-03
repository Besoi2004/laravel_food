<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;

class MenuController extends Controller
{
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

}
