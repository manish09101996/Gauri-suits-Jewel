<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Http\Requests\ApplyCouponRequest;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function index()
    {
        $summary = $this->cartService->getCartSummary();
        return view('storefront.cart', compact('summary'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $productId = (int) $request->input('product_id');
        $variantId = $request->filled('variant_id') ? (int) $request->input('variant_id') : null;
        $quantity = (int) $request->input('quantity', 1);

        $result = $this->cartService->addItem($productId, $variantId, $quantity);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($result, $result['success'] ? 200 : 422);
        }

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return redirect()->route('cart.index')->with('success', $result['message']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'quantity' => 'required|integer|min:0',
        ]);

        $result = $this->cartService->updateQuantity(
            (int) $request->input('item_id'),
            (int) $request->input('quantity')
        );

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($result, $result['success'] ? 200 : 422);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function remove(Request $request, int $id)
    {
        $result = $this->cartService->removeItem($id);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($result);
        }

        return back()->with('success', 'Item removed from your cart.');
    }

    public function applyCoupon(ApplyCouponRequest $request)
    {
        $result = $this->cartService->applyCoupon($request->input('code'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($result, $result['success'] ? 200 : 422);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function removeCoupon(Request $request)
    {
        $result = $this->cartService->removeCoupon();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($result);
        }

        return back()->with('success', 'Coupon removed.');
    }

    public function summary()
    {
        return response()->json($this->cartService->getCartSummary());
    }
}
