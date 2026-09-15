<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    public function index(Request $request)
    {
        $query = Order::with(['user', 'items', 'payment', 'shipment'])->latest();

        if ($request->filled('search')) {
            $s = trim($request->input('search'));
            $query->where(function ($q) use ($s) {
                $q->where('order_number', 'like', "%{$s}%")
                    ->orWhere('shipping_name', 'like', "%{$s}%")
                    ->orWhere('shipping_phone', 'like', "%{$s}%")
                    ->orWhere('shipping_email', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product.images', 'items.variant', 'payment', 'shipment']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,packed,shipped,out_for_delivery,delivered,cancelled,returned,refunded',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $newStatus = $request->input('status');

        if ($newStatus === 'cancelled' && $order->status !== 'cancelled') {
            $this->orderService->cancelOrder($order, $request->input('admin_notes', 'Cancelled by Admin'));
        } else {
            $this->orderService->updateOrderStatus($order, $newStatus);
            if ($request->filled('admin_notes')) {
                $order->update([
                    'admin_notes' => ($order->admin_notes ? $order->admin_notes . "\n" : '') . $request->input('admin_notes'),
                ]);
            }
        }

        return back()->with('success', "Order #{$order->order_number} status updated to " . ucfirst(str_replace('_', ' ', $newStatus)));
    }

    public function updateShipment(Request $request, Order $order)
    {
        $validated = $request->validate([
            'carrier' => 'required|string|max:100',
            'tracking_number' => 'required|string|max:100',
            'tracking_url' => 'nullable|url|max:255',
            'estimated_delivery' => 'nullable|date',
        ]);

        $shipment = $order->shipment ?? $order->shipments()->create(['order_id' => $order->id]);
        $shipment->update($validated);

        return back()->with('success', 'Tracking and shipment details updated.');
    }

    public function markPaid(Order $order)
    {
        $order->update(['payment_status' => 'paid']);
        $order->payment?->update(['status' => 'successful', 'paid_at' => Carbon::now()]);

        return back()->with('success', 'Order marked as paid.');
    }

    public function invoice(Order $order)
    {
        $order->load(['items', 'payment', 'shipment', 'user']);
        return view('admin.orders.invoice', compact('order'));
    }
}
