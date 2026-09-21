<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Banner;
use Symfony\Component\HttpFoundation\Response;

class ShareSettings
{
    public function handle(Request $request, Closure $next): Response
    {
        $settings = Setting::getAll();

        // Cached active parent categories for navigation
        $navCategories = Category::active()
            ->whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->active()->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        // Announcement banner
        $announcement = Banner::where('type', 'announcement')
            ->where('is_active', true)
            ->first();

        // Cart items count
        $cartCount = 0;
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->withCount('items')->first();
            $cartCount = $cart ? $cart->items_count : 0;
        } else {
            $sessionId = $request->session()->getId();
            $cart = Cart::where('session_id', $sessionId)->withCount('items')->first();
            $cartCount = $cart ? $cart->items_count : 0;
        }

        // Wishlist items count
        $wishlistCount = 0;
        if (Auth::check()) {
            $wishlist = Wishlist::where('user_id', Auth::id())->withCount('items')->first();
            $wishlistCount = $wishlist ? $wishlist->items_count : 0;
        }

        $currencySymbol = $settings['currency_symbol'] ?? '$';
        $currencyCode = $settings['currency_code'] ?? 'AUD';

        View::share('storeSettings', $settings);
        View::share('currencySymbol', $currencySymbol);
        View::share('currencyCode', $currencyCode);
        View::share('navCategories', $navCategories);
        View::share('announcement', $announcement);
        View::share('cartCount', $cartCount);
        View::share('wishlistCount', $wishlistCount);

        return $next($request);
    }
}
