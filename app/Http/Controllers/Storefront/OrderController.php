<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function success(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product.images', 'payment', 'shipment'])
            ->firstOrFail();

        // Customer can only view if logged in or if they just placed the order
        if ($order->user_id && Auth::check() && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        return view('storefront.order-success', compact('order'));
    }

    /**
     * Stripe Checkout Return Callback (Success)
     */
    public function stripeSuccess(Request $request)
    {
        $sessionId = $request->input('session_id');
        $orderNumber = $request->input('order');

        if (!$orderNumber) {
            return redirect()->route('home');
        }

        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if ($sessionId) {
            $verified = $this->paymentService->verifyAndCompleteStripeSession($sessionId, $order);
            if ($verified) {
                return redirect()->route('order.success', $order->order_number)
                    ->with('success', 'Your Stripe payment was successful and your couture order is confirmed!');
            }
        }

        // If session was not verified yet
        return redirect()->route('order.success', $order->order_number)
            ->with('info', 'Your order has been recorded. Payment status will be confirmed shortly.');
    }

    /**
     * Stripe Checkout Cancel Callback
     */
    public function stripeCancel(Request $request)
    {
        $orderNumber = $request->input('order');
        if (!$orderNumber) {
            return redirect()->route('home');
        }

        $order = Order::where('order_number', $orderNumber)->first();
        if ($order) {
            return redirect()->route('order.success', $order->order_number)
                ->with('error', 'Stripe payment was cancelled. Your order remains pending. You can contact our boutique concierge to complete payment.');
        }

        return redirect()->route('home');
    }

    /**
     * Stripe Sandbox Simulation Pay View (Used when sandbox/mock testing without live keys)
     */
    public function stripePay(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product.images', 'payment'])
            ->firstOrFail();

        return view('storefront.stripe-pay', [
            'order' => $order,
            'publicKey' => $this->paymentService->getStripePublicKey(),
            'sessionId' => $order->payment?->stripe_session_id ?? ('cs_sim_' . substr(md5($order->order_number), 0, 16)),
        ]);
    }

    /**
     * Legacy payment callback kept for compatibility
     */
    public function paymentCallback(Request $request)
    {
        $orderNumber = $request->input('order_number');
        if (!$orderNumber) {
            return redirect()->route('home');
        }
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        return redirect()->route('order.success', $order->order_number);
    }

    public function trackOrder(Request $request)
    {
        $order = null;
        $searched = false;

        if ($request->filled('order_number')) {
            $searched = true;
            $orderNumber = trim($request->input('order_number'));
            $contact = trim($request->input('contact', ''));

            $query = Order::where('order_number', $orderNumber)
                ->with(['items.product.images', 'payment', 'shipment']);

            if ($contact) {
                $query->where(function ($q) use ($contact) {
                    $q->where('shipping_phone', 'like', "%{$contact}%")
                        ->orWhere('shipping_email', 'like', "%{$contact}%")
                        ->orWhere('guest_phone', 'like', "%{$contact}%")
                        ->orWhere('guest_email', 'like', "%{$contact}%");
                });
            }

            $order = $query->first();
        }

        return view('storefront.track-order', compact('order', 'searched'));
    }

    public function invoice(string $id)
    {
        $order = Order::with(['items', 'payment', 'shipment'])->findOrFail($id);

        if ($order->user_id && (!Auth::check() || Auth::id() !== $order->user_id)) {
            if (!Auth::guard('admin')->check()) {
                abort(403);
            }
        }

        return view('storefront.invoice', compact('order'));
    }
}
