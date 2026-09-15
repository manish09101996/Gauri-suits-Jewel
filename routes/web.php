<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Storefront\HomeController;
use App\Http\Controllers\Storefront\ShopController;
use App\Http\Controllers\Storefront\ProductController;
use App\Http\Controllers\Storefront\CartController;
use App\Http\Controllers\Storefront\CheckoutController;
use App\Http\Controllers\Storefront\OrderController;
use App\Http\Controllers\Storefront\CustomerAccountController;
use App\Http\Controllers\Storefront\WishlistController;
use App\Http\Controllers\Storefront\SearchController;
use App\Http\Controllers\Storefront\ReviewController;
use App\Http\Controllers\Storefront\BlogController;
use App\Http\Controllers\Storefront\PageController;
use App\Http\Controllers\Webhook\RazorpayWebhookController;

/*
|--------------------------------------------------------------------------
| Storefront Public Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop & Catalog Collections
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products', [ShopController::class, 'index'])->name('shop.products');
Route::get('/new-arrivals', [ShopController::class, 'index'])->name('shop.new-arrivals');
Route::get('/best-sellers', [ShopController::class, 'index'])->name('shop.best-sellers');
Route::get('/suits', [ShopController::class, 'index'])->name('shop.suits');
Route::get('/punjabi-suits', [ShopController::class, 'index'])->name('shop.punjabi-suits');
Route::get('/designer-suits', [ShopController::class, 'index'])->name('shop.designer-suits');
Route::get('/party-wear', [ShopController::class, 'index'])->name('shop.party-wear');
Route::get('/wedding-collection', [ShopController::class, 'index'])->name('shop.wedding-collection');
Route::get('/bridal-collection', [ShopController::class, 'index'])->name('shop.bridal-collection');
Route::get('/jewellery', [ShopController::class, 'index'])->name('shop.jewellery');
Route::get('/accessories', [ShopController::class, 'index'])->name('shop.accessories');
Route::get('/sale', [ShopController::class, 'index'])->name('shop.sale');

// Category & Collection filtered shop
Route::get('/category/{slug}', [ShopController::class, 'index'])->name('shop.category');
Route::get('/collection/{slug}', [ShopController::class, 'index'])->name('shop.collection');

// Product Detail
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/api/quick-view/{id}', [ProductController::class, 'quickView'])->name('product.quick-view');

// Search & AJAX suggestions
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

// Cart (Page & AJAX)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon/apply', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Route::get('/cart/summary', [CartController::class, 'summary'])->name('cart.summary');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/checkout/shipping-rate', [CheckoutController::class, 'calculateShippingRate'])->name('checkout.shipping-rate');

// Order Confirmation, Payment Callback, Tracking
Route::get('/order/success/{order_number}', [OrderController::class, 'success'])->name('order.success');
Route::post('/order/payment/callback', [OrderController::class, 'paymentCallback'])->name('order.payment.callback');
Route::get('/track-order', [OrderController::class, 'trackOrder'])->name('order.track');
Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');

// Reviews
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Wishlist
Route::get('/account/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/wishlist/move-to-cart/{id}', [WishlistController::class, 'moveToCart'])->name('wishlist.move-to-cart');
Route::post('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');

// Blog CMS
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Informational & Policy Pages
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');
Route::post('/contact', [PageController::class, 'storeContact'])->name('pages.contact.store');
Route::get('/faq', [PageController::class, 'faq'])->name('pages.faq');
Route::post('/newsletter/subscribe', [PageController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');

Route::get('/shipping-policy', [PageController::class, 'shippingPolicy'])->name('pages.shipping-policy');
Route::get('/return-policy', [PageController::class, 'returnPolicy'])->name('pages.return-policy');
Route::get('/refund-policy', [PageController::class, 'refundPolicy'])->name('pages.refund-policy');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('pages.privacy-policy');
Route::get('/terms-and-conditions', [PageController::class, 'termsAndConditions'])->name('pages.terms');

// Webhook for Razorpay
Route::post('/razorpay/webhook', [RazorpayWebhookController::class, 'handle'])->name('razorpay.webhook');

/*
|--------------------------------------------------------------------------
| Customer Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomerAccountController::class, 'showLogin'])->name('customer.login');
    Route::post('/login', [CustomerAccountController::class, 'login']);
    Route::get('/register', [CustomerAccountController::class, 'showRegister'])->name('customer.register');
    Route::post('/register', [CustomerAccountController::class, 'register']);
    Route::get('/forgot-password', [CustomerAccountController::class, 'showForgotPassword'])->name('password.request');
});

Route::post('/logout', [CustomerAccountController::class, 'logout'])->name('customer.logout');

/*
|--------------------------------------------------------------------------
| Customer Account Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/', [CustomerAccountController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [CustomerAccountController::class, 'profile'])->name('profile');
    Route::post('/profile', [CustomerAccountController::class, 'updateProfile'])->name('profile.update');
    Route::get('/orders', [CustomerAccountController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [CustomerAccountController::class, 'orderDetail'])->name('orders.detail');
    Route::get('/addresses', [CustomerAccountController::class, 'addresses'])->name('addresses');
    Route::post('/addresses', [CustomerAccountController::class, 'storeAddress'])->name('addresses.store');
    Route::delete('/addresses/{id}', [CustomerAccountController::class, 'deleteAddress'])->name('addresses.delete');
    Route::post('/addresses/{id}/default', [CustomerAccountController::class, 'setDefaultAddress'])->name('addresses.default');
});
