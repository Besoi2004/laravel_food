<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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
        Route::get('/menus', [AdminController::class, 'menus'])->name('admin.menus');
        Route::get('/menus/create', [AdminController::class, 'create'])->name('admin.menus.create');
        Route::post('/menus/store', [AdminController::class, 'store'])->name('admin.menus.store');
        Route::get('/menus/edit/{id}', [AdminController::class, 'edit'])->name('admin.menus.edit');
        Route::put('/menus/update/{id}', [AdminController::class, 'update'])->name('admin.menus.update');
        Route::delete('/menus/delete/{id}', [AdminController::class, 'destroy'])->name('admin.menus.delete');

        // Orders
        Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
        Route::get('/orders/create', [AdminController::class, 'createOrder'])->name('admin.orders.create');
        Route::post('/orders/store', [AdminController::class, 'storeOrder'])->name('admin.orders.store');
        Route::get('/orders/{id}/details', [AdminController::class, 'orderDetails'])->name('admin.orders.details');
        Route::get('/orders/{id}/edit', [AdminController::class, 'editOrder'])->name('admin.orders.edit');
        Route::put('/orders/{id}', [AdminController::class, 'updateOrder'])->name('admin.orders.update');
        Route::delete('/orders/{id}', [AdminController::class, 'destroyOrder'])->name('admin.orders.destroy');

        // Order Details
        Route::get('/order-details', [AdminController::class, 'orderDetails'])->name('admin.order-details');
        Route::get('/order-details/create', [AdminController::class, 'createOrderDetail'])->name('admin.order-details.create');
        Route::post('/order-details', [AdminController::class, 'storeOrderDetail'])->name('admin.order-details.store');
        Route::get('/order-details/{id}', [AdminController::class, 'showOrderDetail'])->name('admin.order-details.show');
        Route::get('/order-details/{id}/edit', [AdminController::class, 'editOrderDetail'])->name('admin.order-details.edit');
        Route::put('/order-details/{id}', [AdminController::class, 'updateOrderDetail'])->name('admin.order-details.update');
        Route::delete('/order-details/{id}', [AdminController::class, 'destroyorderDetail'])->name('admin.order-details.destroy');
    });
});

// Remove duplicate dashboard route
// Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');