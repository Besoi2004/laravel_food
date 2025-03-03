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

        

    }
