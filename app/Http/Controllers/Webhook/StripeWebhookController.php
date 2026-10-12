<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = $this->paymentService->getStripeWebhookSecret();

        // If webhook secret configured, verify signature
        if ($webhookSecret && $sigHeader) {
            $elements = [];
            foreach (explode(',', $sigHeader) as $part) {
                $pieces = explode('=', $part, 2);
                if (count($pieces) === 2) {
                    $elements[trim($pieces[0])] = trim($pieces[1]);
                }
            }
            if (isset($elements['t'], $elements['v1'])) {
                $signedPayload = "{$elements['t']}.{$payload}";
                $expectedSig = hash_hmac('sha256', $signedPayload, $webhookSecret);
                if (!hash_equals($expectedSig, $elements['v1'])) {
                    Log::warning('Stripe Webhook: Signature verification failed');
                    return response()->json(['error' => 'Invalid signature'], 400);
                }
            }
        }

        $event = json_decode($payload, true);
        if (!$event || !isset($event['type'])) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        $type = $event['type'];
        Log::info("Stripe Webhook received: {$type}");

        if ($type === 'checkout.session.completed') {
            $session = $event['data']['object'] ?? [];
            $orderNumber = $session['client_reference_id'] ?? ($session['metadata']['order_number'] ?? null);
            $sessionId = $session['id'] ?? null;
            $paymentIntentId = $session['payment_intent'] ?? $sessionId;

            if ($orderNumber) {
                $order = Order::where('order_number', $orderNumber)->first();
                if ($order && $order->payment_status !== 'paid') {
                    $this->paymentService->markPaymentSuccessful(
                        $order,
                        $paymentIntentId ?: 'stripe_hook_' . time(),
                        'stripe',
                        $session
                    );
                    Log::info("Stripe Webhook: Order {$orderNumber} marked paid via session.completed");
                }
            }
        } elseif ($type === 'payment_intent.succeeded') {
            $paymentIntent = $event['data']['object'] ?? [];
            $orderNumber = $paymentIntent['metadata']['order_number'] ?? null;
            $piId = $paymentIntent['id'] ?? null;

            if ($orderNumber) {
                $order = Order::where('order_number', $orderNumber)->first();
                if ($order && $order->payment_status !== 'paid') {
                    $this->paymentService->markPaymentSuccessful(
                        $order,
                        $piId ?: 'stripe_hook_' . time(),
                        'stripe',
                        $paymentIntent
                    );
                    Log::info("Stripe Webhook: Order {$orderNumber} marked paid via payment_intent.succeeded");
                }
            }
        }

        return response()->json(['received' => true]);
    }
}
