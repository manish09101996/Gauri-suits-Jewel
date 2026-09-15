<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request)
    {
        $productId = (int) $request->input('product_id');
        $user = Auth::user();
        $isVerifiedPurchase = false;
        $orderId = null;

        if ($user) {
            // Check if customer purchased this product
            $purchasedOrder = Order::where('user_id', $user->id)
                ->where('payment_status', 'paid')
                ->whereHas('items', function ($q) use ($productId) {
                    $q->where('product_id', $productId);
                })
                ->latest()
                ->first();

            if ($purchasedOrder) {
                $isVerifiedPurchase = true;
                $orderId = $purchasedOrder->id;
            }

            // Prevent duplicate reviews
            $existing = Review::where('product_id', $productId)
                ->where('user_id', $user->id)
                ->first();

            if ($existing) {
                return back()->with('error', 'You have already submitted a review for this product.');
            }
        }

        Review::create([
            'product_id' => $productId,
            'user_id' => $user?->id,
            'order_id' => $orderId,
            'customer_name' => $user ? $user->name : $request->input('customer_name', 'Verified Buyer'),
            'customer_email' => $user ? $user->email : $request->input('customer_email'),
            'rating' => (int) $request->input('rating'),
            'title' => $request->input('title'),
            'comment' => $request->input('comment'),
            'status' => 'pending', // Requires admin approval
            'is_verified_purchase' => $isVerifiedPurchase,
        ]);

        return back()->with('success', 'Thank you for your review! It will appear on our website once approved by our team.');
    }
}
