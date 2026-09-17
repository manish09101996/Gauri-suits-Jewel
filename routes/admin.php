<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ManualOrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\AbandonedCartController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\ReelController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\LiveVisitorController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AdminLoginController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Protected Panel Routes
|--------------------------------------------------------------------------
*/
Route::middleware('admin.auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chart-data');

    // Products
    Route::resource('products', ProductController::class);
    Route::post('/products/{product}/duplicate', [ProductController::class, 'duplicate'])->name('products.duplicate');
    Route::delete('/products/images/{id}', [ProductController::class, 'deleteImage'])->name('products.images.delete');
    Route::post('/products/images/{id}/primary', [ProductController::class, 'setPrimaryImage'])->name('products.images.primary');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('/orders/{order}/shipment', [OrderController::class, 'updateShipment'])->name('orders.shipment');
    Route::post('/orders/{order}/mark-paid', [OrderController::class, 'markPaid'])->name('orders.mark-paid');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

    // Manual Orders
    Route::get('/manual-orders/create', [ManualOrderController::class, 'create'])->name('manual-orders.create');
    Route::post('/manual-orders', [ManualOrderController::class, 'store'])->name('manual-orders.store');

    // Customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');

    // Coupons
    Route::resource('coupons', CouponController::class);

    // Reviews Moderation
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Abandoned Carts
    Route::get('/abandoned-carts', [AbandonedCartController::class, 'index'])->name('abandoned-carts.index');

    // Shipping Management
    Route::get('/shipping', [ShippingController::class, 'index'])->name('shipping.index');
    Route::post('/shipping/settings', [ShippingController::class, 'updateSettings'])->name('shipping.settings.update');
    Route::post('/shipping/zones', [ShippingController::class, 'storeZone'])->name('shipping.zones.store');
    Route::post('/shipping/zones/{zone}/rates', [ShippingController::class, 'storeRate'])->name('shipping.rates.store');
    Route::delete('/shipping/rates/{rate}', [ShippingController::class, 'destroyRate'])->name('shipping.rates.destroy');

    // Blog CMS
    Route::resource('blog', BlogController::class);

    // Hero Banners
    Route::resource('banners', BannerController::class);

    // Videos
    Route::resource('videos', VideoController::class);

    // Reels
    Route::resource('reels', ReelController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');

    // Live Visitors
    Route::get('/live-visitors', [LiveVisitorController::class, 'index'])->name('live-visitors.index');

    // Store Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Admin Users & Staff
    Route::get('/admins', [AdminUserController::class, 'index'])->name('admins.index');
    Route::post('/admins', [AdminUserController::class, 'store'])->name('admins.store');
    Route::put('/admins/{admin}', [AdminUserController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{admin}', [AdminUserController::class, 'destroy'])->name('admins.destroy');
});
