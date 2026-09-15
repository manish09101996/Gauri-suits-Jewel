<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('customer.login')->with('info', 'Please sign in to view your wishlist.');
        }

        $wishlist = Wishlist::firstOrCreate(['user_id' => Auth::id()]);
        $items = $wishlist->items()->with(['product.images', 'product.variants'])->latest()->get();

        return view('storefront.account.wishlist', compact('items'));
    }

    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'require_auth' => true,
                'message' => 'Please login to save items to your wishlist.',
            ], 401);
        }

        $productId = (int) $request->input('product_id');
        $product = Product::published()->findOrFail($productId);

        $wishlist = Wishlist::firstOrCreate(['user_id' => Auth::id()]);
        $existing = WishlistItem::where('wishlist_id', $wishlist->id)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            $inWishlist = false;
            $message = 'Removed from your wishlist.';
        } else {
            WishlistItem::create([
                'wishlist_id' => $wishlist->id,
                'product_id' => $productId,
            ]);
            $inWishlist = true;
            $message = 'Added to your wishlist.';
        }

        $count = $wishlist->items()->count();

        return response()->json([
            'success' => true,
            'in_wishlist' => $inWishlist,
            'message' => $message,
            'count' => $count,
        ]);
    }

    public function moveToCart(Request $request, int $id)
    {
        $item = WishlistItem::whereHas('wishlist', function ($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($id);

        $product = $item->product;
        $variant = $product->variants->first();

        $addResult = $this->cartService->addItem($product->id, $variant?->id, 1);

        if ($addResult['success']) {
            $item->delete();
            return back()->with('success', "{$product->name} moved to your cart!");
        }

        return back()->with('error', $addResult['message']);
    }

    public function remove(int $id)
    {
        WishlistItem::whereHas('wishlist', function ($q) {
            $q->where('user_id', Auth::id());
        })->where('id', $id)->delete();

        return back()->with('success', 'Item removed from your wishlist.');
    }
}
