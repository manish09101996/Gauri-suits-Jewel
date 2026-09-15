<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'sales');
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $data = match ($type) {
            'orders' => Order::whereBetween('created_at', [$start, $end])->with('user')->latest()->paginate(25),
            'customers' => User::whereBetween('created_at', [$start, $end])->withCount('orders')->latest()->paginate(25),
            'products' => OrderItem::whereBetween('created_at', [$start, $end])
                ->selectRaw('product_id, product_name, product_sku, SUM(quantity) as total_qty, SUM(total) as total_sales')
                ->groupBy('product_id', 'product_name', 'product_sku')
                ->orderByDesc('total_sales')
                ->paginate(25),
            'inventory' => InventoryMovement::whereBetween('created_at', [$start, $end])->with('product')->latest()->paginate(25),
            default => Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$start, $end])
                ->latest()
                ->paginate(25),
        };

        return view('admin.reports.index', compact('type', 'startDate', 'endDate', 'data'));
    }

    public function export(Request $request): StreamedResponse
    {
        $type = $request->input('type', 'sales');
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
        $filename = "gauri-{$type}-report-{$startDate}-to-{$endDate}.csv";

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        return response()->streamDownload(function () use ($type, $start, $end) {
            $handle = fopen('php://output', 'w');

            if ($type === 'sales' || $type === 'orders') {
                fputcsv($handle, ['Order #', 'Date', 'Customer', 'Phone', 'Payment Method', 'Payment Status', 'Order Status', 'Total Amount']);

                Order::whereBetween('created_at', [$start, $end])
                    ->chunk(100, function ($orders) use ($handle) {
                        foreach ($orders as $order) {
                            fputcsv($handle, [
                                $order->order_number,
                                $order->created_at->format('Y-m-d H:i'),
                                $order->customer_name,
                                $order->shipping_phone,
                                strtoupper($order->payment_method),
                                ucfirst($order->payment_status),
                                ucfirst($order->status),
                                $order->total_amount,
                            ]);
                        }
                    });
            } elseif ($type === 'products') {
                fputcsv($handle, ['Product ID', 'Name', 'SKU', 'Units Sold', 'Total Revenue']);

                $items = OrderItem::whereBetween('created_at', [$start, $end])
                    ->selectRaw('product_id, product_name, product_sku, SUM(quantity) as total_qty, SUM(total) as total_sales')
                    ->groupBy('product_id', 'product_name', 'product_sku')
                    ->orderByDesc('total_sales')
                    ->get();

                foreach ($items as $item) {
                    fputcsv($handle, [
                        $item->product_id,
                        $item->product_name,
                        $item->product_sku,
                        $item->total_qty,
                        $item->total_sales,
                    ]);
                }
            } elseif ($type === 'customers') {
                fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Orders Count', 'Total Spent', 'Registered On']);

                User::whereBetween('created_at', [$start, $end])
                    ->withCount('orders')
                    ->chunk(100, function ($users) use ($handle) {
                        foreach ($users as $user) {
                            fputcsv($handle, [
                                $user->id,
                                $user->name,
                                $user->email,
                                $user->phone,
                                $user->orders_count,
                                $user->totalSpent(),
                                $user->created_at->format('Y-m-d'),
                            ]);
                        }
                    });
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
