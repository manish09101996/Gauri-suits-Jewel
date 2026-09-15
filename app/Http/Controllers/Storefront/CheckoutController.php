<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Services\ShippingService;
use App\Http\Requests\CheckoutRequest;
use App\Models\Address;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected CheckoutService $checkoutService,
        protected OrderService $orderService,
        protected PaymentService $paymentService,
        protected ShippingService $shippingService
    ) {}

    public function index()
    {
        $cart = $this->cartService->getCart();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is waiting for something beautiful.');
        }

        $user = Auth::user();
        $addresses = $user ? $user->addresses : collect();
        $defaultAddress = $user ? $user->defaultAddress : null;

        $selectedState = $defaultAddress ? $defaultAddress->state : 'Punjab';
        $totals = $this->checkoutService->calculateCheckoutTotals($cart, $selectedState, 'cod');

        $codAvailable = $this->shippingService->isCodAvailable($totals['subtotal']);
        $razorpayKeyId = $this->paymentService->getKeyId();

        $states = [
            'Punjab', 'Chandigarh', 'Haryana', 'Delhi', 'Himachal Pradesh',
            'Jammu and Kashmir', 'Rajasthan', 'Uttar Pradesh', 'Uttarakhand',
            'Maharashtra', 'Gujarat', 'Karnataka', 'Tamil Nadu', 'Telangana',
            'West Bengal', 'Kerala', 'Madhya Pradesh', 'Bihar', 'Assam',
            'Andhra Pradesh', 'Odisha', 'Goa', 'Other States'
        ];

        return view('storefront.checkout', compact(
            'cart',
            'user',
            'addresses',
            'defaultAddress',
            'totals',
            'codAvailable',
            'razorpayKeyId',
            'states'
        ));
    }

    public function calculateShippingRate(Request $request)
    {
        $state = $request->input('state', 'Punjab');
        $paymentMethod = $request->input('payment_method', 'cod');
        $cart = $this->cartService->getCart();

        try {
            $totals = $this->checkoutService->calculateCheckoutTotals($cart, $state, $paymentMethod);
            return response()->json([
                'success' => true,
                'totals' => $totals,
                'cod_available' => $this->shippingService->isCodAvailable($totals['subtotal']),
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function process(CheckoutRequest $request)
    {
        $cart = $this->cartService->getCart();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $customerData = [
            'user_id' => Auth::id(),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'name' => $request->input('name'),
        ];

        $shippingAddress = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address_line1' => $request->input('address_line1'),
            'address_line2' => $request->input('address_line2'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'postal_code' => $request->input('postal_code'),
            'country' => $request->input('country', 'India'),
        ];

        $paymentMethod = $request->input('payment_method');

        // Save address for logged-in user if requested
        if (Auth::check() && $request->boolean('save_address')) {
            $nameParts = explode(' ', $request->input('name'), 2);
            Address::create([
                'user_id' => Auth::id(),
                'first_name' => $nameParts[0],
                'last_name' => $nameParts[1] ?? '',
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'address_line1' => $request->input('address_line1'),
                'address_line2' => $request->input('address_line2'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'postal_code' => $request->input('postal_code'),
                'country' => $request->input('country', 'India'),
                'is_default' => !Auth::user()->addresses()->exists(),
            ]);
        }

        try {
            $order = $this->orderService->createOrder(
                $cart,
                $customerData,
                $shippingAddress,
                $paymentMethod,
                $request->input('notes')
            );

            if ($paymentMethod === 'cod') {
                return redirect()->route('order.success', $order->order_number)
                    ->with('success', 'Your order has been placed successfully!');
            }

            // Razorpay Payment flow
            $razorpayOrder = $this->paymentService->createRazorpayOrder($order);

            return view('storefront.razorpay-pay', [
                'order' => $order,
                'razorpayOrder' => $razorpayOrder,
                'keyId' => $this->paymentService->getKeyId(),
            ]);
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
