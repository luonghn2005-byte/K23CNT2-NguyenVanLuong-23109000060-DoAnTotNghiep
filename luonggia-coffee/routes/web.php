<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientAuthController;

// --- PHẦN KHÁCH HÀNG (CLIENT) ---
Route::get('/', [ClientController::class, 'index'])->name('client.home');
Route::post('/client/checkout', [ClientController::class, 'checkout'])->name('client.checkout');
Route::post('/client/check-voucher', [ClientController::class, 'checkVoucher'])->name('client.check_voucher');

Route::get('/client/login', [ClientAuthController::class, 'showLogin'])->name('client.login');
Route::post('/client/login', [ClientAuthController::class, 'login']);
Route::get('/client/register', [ClientAuthController::class, 'showRegister'])->name('client.register');
Route::post('/client/register', [ClientAuthController::class, 'register']);
Route::post('/client/logout', [ClientAuthController::class, 'logout'])->name('client.logout');


// --- PHẦN QUẢN TRỊ (ADMIN) ---
Route::get('/login',  [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Các module quản lý
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('users', UserController::class);
        Route::resource('branches', BranchController::class);
        Route::resource('customers', CustomerController::class)->only(['index', 'show', 'destroy']);
        
        // Đã cập nhật thêm 'update' cho Voucher
        Route::resource('vouchers', VoucherController::class)->only(['index', 'store', 'update', 'destroy']);
        
        // Module Đơn hàng
        Route::resource('orders', OrderController::class)->only(['index', 'show']);
        Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });

    // Bán hàng (POS)
    Route::prefix('pos')->name('pos.')->group(function () {
        Route::get('/', [PosController::class, 'index'])->name('index');
        Route::post('/checkout', [PosController::class, 'checkout'])->name('checkout');
        Route::post('/check-voucher', [PosController::class, 'checkVoucher'])->name('check_voucher');
    });
}); 