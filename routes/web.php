<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDtailController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        
        // Dashboard & Auth
        Route::get('/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

        // Menus
        Route::get('/menus', [MenuController::class, 'menus'])->name('admin.menus');
        Route::get('/menus/create', [MenuController::class, 'create'])->name('admin.menus.create');
        Route::post('/menus/store', [MenuController::class, 'store'])->name('admin.menus.store');
        Route::get('/menus/edit/{id}', [MenuController::class, 'edit'])->name('admin.menus.edit');
        Route::put('/menus/update/{id}', [MenuController::class, 'update'])->name('admin.menus.update');
        Route::delete('/menus/delete/{id}', [MenuController::class, 'destroy'])->name('admin.menus.delete');

        // Orders
        Route::get('/orders', [OrderController::class, 'orders'])->name('admin.orders');
        Route::get('/orders/create', [OrderController::class, 'createOrder'])->name('admin.orders.create');
        Route::post('/orders/store', [OrderController::class, 'storeOrder'])->name('admin.orders.store');
        Route::get('/orders/{id}/details', [OrderController::class, 'orderDetails'])->name('admin.orders.details');
        Route::get('/orders/{id}/edit', [OrderController::class, 'editOrder'])->name('admin.orders.edit');
        Route::put('/orders/{id}', [OrderController::class, 'updateOrder'])->name('admin.orders.update');
        Route::delete('/orders/{id}', [OrderController::class, 'destroyOrder'])->name('admin.orders.destroy');

        // Order Details
        Route::get('/order-details', [OrderDtailController::class, 'orderDetails'])->name('admin.order-details');
        Route::get('/order-details/create', [OrderDtailController::class, 'createOrderDetail'])->name('admin.order-details.create');
        Route::post('/order-details', [OrderDtailController::class, 'storeOrderDetail'])->name('admin.order-details.store');
        Route::get('/order-details/{id}', [OrderDtailController::class, 'showOrderDetail'])->name('admin.order-details.show');
        Route::get('/order-details/{id}/edit', [OrderDtailController::class, 'editOrderDetail'])->name('admin.order-details.edit');
        Route::put('/order-details/{id}', [OrderDtailController::class, 'updateOrderDetail'])->name('admin.order-details.update');
        Route::delete('/order-details/{id}', [OrderDtailController::class, 'destroyorderDetail'])->name('admin.order-details.destroy');
    });
});


Route::middleware(['auth','role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'UserDashboard'])->name('user.dashboard');
});
// Remove duplicate dashboard route
// Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');