<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Coupon;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(): Cart
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $this->mergeSessionCartIntoUserCart($cart);
            return $cart->load(['items.product.images', 'items.variant', 'coupon']);
        }

        $sessionId = Session::getId();
        $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        return $cart->load(['items.product.images', 'items.variant', 'coupon']);
    }

    public function addItem(int $productId, ?int $variantId = null, int $quantity = 1): array
    {
        $product = Product::published()->findOrFail($productId);
        $variant = null;
        $unitPrice = $product->effective_price;
        $maxStock = $product->stock;

        if (!$variantId && $product->variants()->exists()) {
            $firstVariant = $product->variants()->where('stock', '>', 0)->first() ?? $product->variants()->first();
            if ($firstVariant) {
                $variantId = $firstVariant->id;
                $variant = $firstVariant;
                $unitPrice = $variant->effective_price;
                $maxStock = $variant->stock;
            }
        } elseif ($variantId) {
            $variant = ProductVariant::where('product_id', $productId)->findOrFail($variantId);
            $unitPrice = $variant->effective_price;
            $maxStock = $variant->stock;
        }

        if ($maxStock < 1) {
            return ['success' => false, 'message' => 'Selected product is out of stock.'];
        }

        $cart = $this->getCart();
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->first();

        $currentQty = $item ? $item->quantity : 0;
        $newQty = $currentQty + $quantity;

        if ($newQty > $maxStock) {
            return [
                'success' => false,
                'message' => "Only {$maxStock} units available in stock."
            ];
        }

        if ($item) {
            $item->update(['quantity' => $newQty, 'price' => $unitPrice]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
                'price' => $unitPrice,
            ]);
        }

        return [
            'success' => true,
            'message' => 'Added to cart successfully.',
            'cart' => $this->getCartSummary(),
        ];
    }

    public function updateQuantity(int $itemId, int $quantity): array
    {
        $cart = $this->getCart();
        $item = CartItem::where('cart_id', $cart->id)->findOrFail($itemId);

        if ($quantity <= 0) {
            $item->delete();
            return [
                'success' => true,
                'message' => 'Item removed from cart.',
                'cart' => $this->getCartSummary(),
            ];
        }

        $maxStock = $item->variant ? $item->variant->stock : $item->product->stock;
        if ($quantity > $maxStock) {
            return [
                'success' => false,
                'message' => "Maximum available stock is {$maxStock}.",
                'cart' => $this->getCartSummary(),
            ];
        }

        $item->update(['quantity' => $quantity]);

        return [
            'success' => true,
            'message' => 'Cart updated.',
            'cart' => $this->getCartSummary(),
        ];
    }

    public function removeItem(int $itemId): array
    {
        $cart = $this->getCart();
        CartItem::where('cart_id', $cart->id)->where('id', $itemId)->delete();

        return [
            'success' => true,
            'message' => 'Item removed from cart.',
            'cart' => $this->getCartSummary(),
        ];
    }

    public function applyCoupon(string $code): array
    {
        $cart = $this->getCart();
        $code = trim(strtoupper($code));
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return ['success' => false, 'message' => 'Invalid coupon code.'];
        }

        if (!$coupon->isValidForAmount($cart->subtotal)) {
            if ($coupon->min_order_amount > $cart->subtotal) {
                return [
                    'success' => false,
                    'message' => "This coupon requires a minimum cart value of ₹" . number_format($coupon->min_order_amount, 0)
                ];
            }
            return ['success' => false, 'message' => 'This coupon has expired or reached its usage limit.'];
        }

        $cart->update(['coupon_id' => $coupon->id]);

        return [
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'cart' => $this->getCartSummary(),
        ];
    }

    public function removeCoupon(): array
    {
        $cart = $this->getCart();
        $cart->update(['coupon_id' => null]);

        return [
            'success' => true,
            'message' => 'Coupon removed.',
            'cart' => $this->getCartSummary(),
        ];
    }

    public function getCartSummary(): array
    {
        $cart = $this->getCart();
        $subtotal = $cart->subtotal;
        $discount = $cart->discount;

        // Configurable free shipping threshold from Settings
        $freeShippingThreshold = (float) Setting::get('free_shipping_threshold', 2999);
        $amountNeededForFreeShipping = max(0, $freeShippingThreshold - $subtotal);
        $freeShippingPercent = $freeShippingThreshold > 0
            ? min(100, round(($subtotal / $freeShippingThreshold) * 100))
            : 100;

        $items = $cart->items->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'slug' => $item->product->slug,
                'url' => route('product.show', $item->product->slug),
                'image' => $item->product->primary_image_url,
                'variant_id' => $item->variant_id,
                'size' => $item->variant?->size,
                'colour' => $item->variant?->colour,
                'price' => (float) $item->price,
                'quantity' => $item->quantity,
                'subtotal' => (float) $item->subtotal,
                'max_stock' => $item->variant ? $item->variant->stock : $item->product->stock,
            ];
        });

        return [
            'items' => $items,
            'total_items' => $cart->total_items,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'coupon_code' => $cart->coupon?->code,
            'free_shipping_threshold' => $freeShippingThreshold,
            'amount_needed_free_shipping' => $amountNeededForFreeShipping,
            'free_shipping_percent' => $freeShippingPercent,
            'free_shipping_unlocked' => $amountNeededForFreeShipping <= 0,
        ];
    }

    public function clearCart(): void
    {
        $cart = $this->getCart();
        $cart->items()->delete();
        $cart->update(['coupon_id' => null]);
    }

    protected function mergeSessionCartIntoUserCart(Cart $userCart): void
    {
        $sessionId = Session::getId();
        $sessionCart = Cart::where('session_id', $sessionId)->first();

        if ($sessionCart && $sessionCart->id !== $userCart->id) {
            foreach ($sessionCart->items as $sessionItem) {
                $existingItem = CartItem::where('cart_id', $userCart->id)
                    ->where('product_id', $sessionItem->product_id)
                    ->where('variant_id', $sessionItem->variant_id)
                    ->first();

                if ($existingItem) {
                    $existingItem->update([
                        'quantity' => $existingItem->quantity + $sessionItem->quantity,
                    ]);
                } else {
                    $sessionItem->update(['cart_id' => $userCart->id]);
                }
            }

            if ($sessionCart->coupon_id && !$userCart->coupon_id) {
                $userCart->update(['coupon_id' => $sessionCart->coupon_id]);
            }

            $sessionCart->delete();
        }
    }
}
