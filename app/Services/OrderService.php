<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\CouponUsage;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class OrderService
{
    public function __construct(
        protected CartService $cartService,
        protected CheckoutService $checkoutService,
        protected InventoryService $inventoryService
    ) {}

    /**
     * Create an order from current cart within a DB transaction.
     */
    public function createOrder(
        Cart $cart,
        array $customerData,
        array $shippingAddress,
        string $paymentMethod = 'cod',
        ?string $notes = null
    ): Order {
        return DB::transaction(function () use ($cart, $customerData, $shippingAddress, $paymentMethod, $notes) {
            $cart->load(['items.product', 'items.variant', 'coupon']);

            if ($cart->items->isEmpty()) {
                throw new Exception('Cannot create order with an empty cart.');
            }

            // Calculate totals
            $state = $shippingAddress['state'] ?? 'Punjab';
            $totals = $this->checkoutService->calculateCheckoutTotals($cart, $state, $paymentMethod);

            // Generate unique order number
            $orderNumber = $this->generateOrderNumber();

            // Create Order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $customerData['user_id'] ?? null,
                'guest_email' => $customerData['email'] ?? null,
                'guest_phone' => $customerData['phone'] ?? null,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $paymentMethod,
                'subtotal' => $totals['subtotal'],
                'discount_amount' => $totals['discount'],
                'coupon_code' => $totals['coupon_code'],
                'shipping_amount' => $totals['shipping'],
                'tax_amount' => $totals['tax'],
                'total_amount' => $totals['total'],
                'shipping_name' => $shippingAddress['name'],
                'shipping_phone' => $shippingAddress['phone'],
                'shipping_email' => $shippingAddress['email'] ?? $customerData['email'] ?? null,
                'shipping_address_line1' => $shippingAddress['address_line1'],
                'shipping_address_line2' => $shippingAddress['address_line2'] ?? null,
                'shipping_city' => $shippingAddress['city'],
                'shipping_state' => $shippingAddress['state'],
                'shipping_postal_code' => $shippingAddress['postal_code'],
                'shipping_country' => $shippingAddress['country'] ?? 'India',
                'notes' => $notes,
            ]);

            // Create Order Items & deduct inventory
            foreach ($cart->items as $cartItem) {
                $variantTitle = null;
                if ($cartItem->variant) {
                    $parts = array_filter([$cartItem->variant->size, $cartItem->variant->colour]);
                    $variantTitle = implode(' / ', $parts);
                }

                $itemTotal = round($cartItem->quantity * $cartItem->price, 2);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'variant_id' => $cartItem->variant_id,
                    'product_name' => $cartItem->product->name,
                    'product_sku' => $cartItem->variant ? $cartItem->variant->sku : $cartItem->product->sku,
                    'variant_title' => $variantTitle,
                    'price' => $cartItem->price,
                    'quantity' => $cartItem->quantity,
                    'total' => $itemTotal,
                ]);

                // Inventory deduction with locking
                $this->inventoryService->deductStock(
                    $cartItem->product_id,
                    $cartItem->variant_id,
                    $cartItem->quantity,
                    $order->order_number,
                    "Order #{$order->order_number}"
                );
            }

            // Record Coupon Usage
            if ($cart->coupon) {
                CouponUsage::create([
                    'coupon_id' => $cart->coupon->id,
                    'user_id' => $customerData['user_id'] ?? null,
                    'order_id' => $order->id,
                    'discount_amount' => $totals['discount'],
                ]);
                $cart->coupon->increment('usage_count');
            }

            // Create Initial Payment Record
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $paymentMethod,
                'amount' => $totals['total'],
                'currency' => 'INR',
                'status' => 'pending',
            ]);

            // Create Shipment Record
            Shipment::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'carrier' => 'Standard Express Logistics',
                'estimated_delivery' => Carbon::now()->addDays(5),
            ]);

            // Clear Cart
            $this->cartService->clearCart();

            return $order->load(['items', 'payment', 'shipment']);
        });
    }

    /**
     * Create manual order by Admin
     */
    public function createManualOrder(array $data, string $adminName = 'Admin'): Order
    {
        return DB::transaction(function () use ($data, $adminName) {
            $orderNumber = $this->generateOrderNumber();
            $subtotal = 0;
            $itemsData = $data['items'] ?? [];

            foreach ($itemsData as $item) {
                $subtotal += ($item['price'] * $item['quantity']);
            }

            $discount = (float) ($data['discount_amount'] ?? 0);
            $shipping = (float) ($data['shipping_amount'] ?? 0);
            $tax = (float) ($data['tax_amount'] ?? 0);
            $total = max(0, $subtotal - $discount + $shipping + $tax);

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $data['user_id'] ?? null,
                'guest_email' => $data['customer_email'] ?? null,
                'guest_phone' => $data['customer_phone'] ?? null,
                'status' => $data['status'] ?? 'confirmed',
                'payment_status' => $data['payment_status'] ?? 'pending',
                'payment_method' => $data['payment_method'] ?? 'manual',
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'shipping_amount' => $shipping,
                'tax_amount' => $tax,
                'total_amount' => $total,
                'shipping_name' => $data['shipping_name'],
                'shipping_phone' => $data['shipping_phone'],
                'shipping_email' => $data['customer_email'] ?? null,
                'shipping_address_line1' => $data['shipping_address_line1'],
                'shipping_address_line2' => $data['shipping_address_line2'] ?? null,
                'shipping_city' => $data['shipping_city'],
                'shipping_state' => $data['shipping_state'],
                'shipping_postal_code' => $data['shipping_postal_code'],
                'shipping_country' => $data['shipping_country'] ?? 'India',
                'notes' => $data['notes'] ?? null,
                'admin_notes' => "Manual Order placed by {$adminName}",
                'is_manual' => true,
            ]);

            foreach ($itemsData as $item) {
                $itemTotal = round($item['price'] * $item['quantity'], 2);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'product_name' => $item['name'],
                    'product_sku' => $item['sku'] ?? 'N/A',
                    'variant_title' => $item['variant_title'] ?? null,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal,
                ]);

                // Deduct stock
                $this->inventoryService->deductStock(
                    $item['product_id'],
                    $item['variant_id'] ?? null,
                    $item['quantity'],
                    $order->order_number,
                    "Manual Order #{$order->order_number}"
                );
            }

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $order->payment_method,
                'amount' => $total,
                'currency' => 'INR',
                'status' => $order->payment_status === 'paid' ? 'successful' : 'pending',
                'paid_at' => $order->payment_status === 'paid' ? Carbon::now() : null,
            ]);

            Shipment::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'carrier' => $data['shipping_carrier'] ?? 'Standard Courier',
                'tracking_number' => $data['tracking_number'] ?? null,
                'estimated_delivery' => Carbon::now()->addDays(5),
            ]);

            return $order->load(['items', 'payment', 'shipment']);
        });
    }

    /**
     * Cancel an order and restore stock.
     */
    public function cancelOrder(Order $order, string $reason = 'Cancelled by Customer'): Order
    {
        return DB::transaction(function () use ($order, $reason) {
            if ($order->status === 'cancelled') {
                return $order;
            }

            $order->load('items');

            // Restore inventory for all items
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    $this->inventoryService->restoreStock(
                        $item->product_id,
                        $item->variant_id,
                        $item->quantity,
                        $order->order_number,
                        "Order #{$order->order_number} Cancelled: {$reason}"
                    );
                }
            }

            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => Carbon::now(),
                'admin_notes' => ($order->admin_notes ? $order->admin_notes . "\n" : '') . "Cancelled: {$reason}",
            ]);

            if ($order->payment && $order->payment->status === 'successful') {
                $order->payment->update(['status' => 'refunded']);
                $order->update(['payment_status' => 'refunded', 'refunded_at' => Carbon::now()]);
            }

            return $order->fresh();
        });
    }

    public function updateOrderStatus(Order $order, string $status): Order
    {
        $order->update(['status' => $status]);

        // Auto update shipment if delivered/shipped
        if ($order->shipment) {
            if ($status === 'shipped' && !$order->shipment->shipped_at) {
                $order->shipment->update([
                    'status' => 'shipped',
                    'shipped_at' => Carbon::now(),
                ]);
            } elseif ($status === 'delivered') {
                $order->shipment->update([
                    'status' => 'delivered',
                    'delivered_at' => Carbon::now(),
                ]);
                if ($order->payment_method === 'cod' && $order->payment_status !== 'paid') {
                    $order->update(['payment_status' => 'paid']);
                    $order->payment?->update([
                        'status' => 'successful',
                        'paid_at' => Carbon::now(),
                    ]);
                }
            }
        }

        return $order->fresh();
    }

    protected function generateOrderNumber(): string
    {
        $prefix = 'GSJ-' . date('Ymd');
        $random = strtoupper(Str::random(5));
        return "{$prefix}-{$random}";
    }
}
