<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RazorpayWebhookController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function handle(Request $request)
    {
        $webhookSecret = $this->paymentService->getKeySecret();
        $signature = $request->header('X-Razorpay-Signature');
        $payload = $request->getContent();

        if ($signature) {
            $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);
            if (!hash_equals($expectedSignature, $signature)) {
                Log::warning('Razorpay Webhook: Invalid Signature');
                return response()->json(['status' => 'invalid_signature'], 400);
            }
        }

        $data = json_decode($payload, true);
        $event = $data['event'] ?? null;

        Log::info("Razorpay Webhook received: {$event}", ['event' => $event]);

        if (in_array($event, ['order.paid', 'payment.captured'])) {
            $paymentEntity = $data['payload']['payment']['entity'] ?? [];
            $razorpayOrderId = $paymentEntity['order_id'] ?? null;
            $razorpayPaymentId = $paymentEntity['id'] ?? null;

            if ($razorpayOrderId) {
                $payment = Payment::where('razorpay_order_id', $razorpayOrderId)->first();
                if ($payment && $payment->order) {
                    $this->paymentService->markPaymentSuccessful(
                        $payment->order,
                        $razorpayPaymentId ?: 'webhook_' . time(),
                        $signature,
                        $data
                    );
                }
            }
        } elseif ($event === 'payment.failed') {
            $paymentEntity = $data['payload']['payment']['entity'] ?? [];
            $razorpayOrderId = $paymentEntity['order_id'] ?? null;

            if ($razorpayOrderId) {
                $payment = Payment::where('razorpay_order_id', $razorpayOrderId)->first();
                if ($payment && $payment->order) {
                    $this->paymentService->markPaymentFailed($payment->order, $paymentEntity['error_description'] ?? 'Payment Failed via Webhook');
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
