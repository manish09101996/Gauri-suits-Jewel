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

    public function paymentCallback(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $razorpayPaymentId = $request->input('razorpay_payment_id');
        $razorpayOrderId = $request->input('razorpay_order_id');
        $razorpaySignature = $request->input('razorpay_signature');

        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Verify Razorpay signature
        $isValid = $this->paymentService->verifyPaymentSignature(
            $razorpayOrderId ?? '',
            $razorpayPaymentId ?? '',
            $razorpaySignature ?? ''
        );

        if ($isValid) {
            $this->paymentService->markPaymentSuccessful(
                $order,
                $razorpayPaymentId,
                $razorpaySignature,
                $request->all()
            );

            return redirect()->route('order.success', $order->order_number)
                ->with('success', 'Payment verified successfully! Your order is confirmed.');
        } else {
            $this->paymentService->markPaymentFailed($order, 'Signature Verification Mismatch');

            return redirect()->route('order.success', $order->order_number)
                ->with('error', 'Payment verification failed. Please contact support or try again.');
        }
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
            // Check if admin is authenticated
            if (!Auth::guard('admin')->check()) {
                abort(403);
            }
        }

        return view('storefront.invoice', compact('order'));
    }
}
