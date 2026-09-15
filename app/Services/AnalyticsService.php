<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Category;
use App\Models\VisitorSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Get dashboard KPI cards with period comparisons.
     */
    public function getKpiMetrics(?string $startDate = null, ?string $endDate = null): array
    {
        $start = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
        $end = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfDay();

        // Previous equivalent period for trend calculation
        $periodDays = $start->diffInDays($end) ?: 1;
        $prevStart = (clone $start)->subDays($periodDays);
        $prevEnd = (clone $start)->subSecond();

        // 1. Total Sales (Paid Orders)
        $currentSales = (float) Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->sum('total_amount');

        $prevSales = (float) Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->sum('total_amount');

        $salesGrowth = $prevSales > 0 ? round((($currentSales - $prevSales) / $prevSales) * 100, 1) : 0;

        // Lifetime total sales
        $lifetimeSales = (float) Order::where('payment_status', 'paid')->sum('total_amount');

        // 2. Total Orders
        $currentOrders = Order::whereBetween('created_at', [$start, $end])->count();
        $prevOrders = Order::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $ordersGrowth = $prevOrders > 0 ? round((($currentOrders - $prevOrders) / $prevOrders) * 100, 1) : 0;
        $lifetimeOrders = Order::count();

        // 3. Total Customers
        $currentCustomers = User::whereBetween('created_at', [$start, $end])->count();
        $lifetimeCustomers = User::count();

        // 4. Low Stock Items
        $lowStockCount = Product::whereColumn('stock', '<=', 'low_stock_threshold')->count();
        $outOfStockCount = Product::where('stock', '<=', 0)->count();

        return [
            'total_sales' => $currentSales,
            'lifetime_sales' => $lifetimeSales,
            'sales_growth' => $salesGrowth,
            'total_orders' => $currentOrders,
            'lifetime_orders' => $lifetimeOrders,
            'orders_growth' => $ordersGrowth,
            'new_customers' => $currentCustomers,
            'total_customers' => $lifetimeCustomers,
            'low_stock_count' => $lowStockCount,
            'out_of_stock_count' => $outOfStockCount,
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
        ];
    }

    /**
     * Daily revenue chart data.
     */
    public function getRevenueChartData(int $days = 30): array
    {
        $startDate = Carbon::now()->subDays($days)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $records = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total, COUNT(*) as orders_count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        $labels = [];
        $data = [];
        $ordersData = [];

        for ($i = $days; $i >= 0; $i--) {
            $dateStr = Carbon::now()->subDays($i)->format('Y-m-d');
            $displayLabel = Carbon::now()->subDays($i)->format('d M');
            $labels[] = $displayLabel;

            if ($records->has($dateStr)) {
                $data[] = (float) $records[$dateStr]->total;
                $ordersData[] = (int) $records[$dateStr]->orders_count;
            } else {
                $data[] = 0.0;
                $ordersData[] = 0;
            }
        }

        return [
            'labels' => $labels,
            'revenue' => $data,
            'orders' => $ordersData,
        ];
    }

    /**
     * Top selling products by units sold.
     */
    public function getTopProducts(int $limit = 5): array
    {
        $items = OrderItem::select('product_name', 'product_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(total) as total_revenue'))
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_quantity')
            ->limit($limit)
            ->get();

        return [
            'labels' => $items->pluck('product_name')->toArray(),
            'quantities' => $items->pluck('total_quantity')->map(fn($v) => (int)$v)->toArray(),
            'revenues' => $items->pluck('total_revenue')->map(fn($v) => (float)$v)->toArray(),
            'raw' => $items,
        ];
    }

    /**
     * Sales breakdown by Category.
     */
    public function getSalesByCategory(): array
    {
        $records = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as category_name', DB::raw('SUM(order_items.total) as category_revenue'), DB::raw('COUNT(DISTINCT order_items.order_id) as orders_count'))
            ->groupBy('categories.name')
            ->orderByDesc('category_revenue')
            ->limit(6)
            ->get();

        return [
            'labels' => $records->pluck('category_name')->toArray(),
            'revenues' => $records->pluck('category_revenue')->map(fn($v) => (float)$v)->toArray(),
            'orders' => $records->pluck('orders_count')->map(fn($v) => (int)$v)->toArray(),
        ];
    }

    /**
     * Order status breakdown.
     */
    public function getOrderStatusDistribution(): array
    {
        return Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
    }

    /**
     * Low stock items query.
     */
    public function getLowStockItems(int $limit = 8)
    {
        return Product::with('category')
            ->whereColumn('stock', '<=', 'low_stock_threshold')
            ->orderBy('stock', 'asc')
            ->limit($limit)
            ->get();
    }

    /**
     * Recent Orders.
     */
    public function getRecentOrders(int $limit = 7)
    {
        return Order::with(['user', 'items'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Recent Customers.
     */
    public function getRecentCustomers(int $limit = 5)
    {
        return User::withCount('orders')
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function ($customer) {
                $customer->total_spent = $customer->totalSpent();
                return $customer;
            });
    }

    /**
     * Active live visitors count in last 15 minutes.
     */
    public function getLiveVisitorsCount(): int
    {
        $cutoff = Carbon::now()->subMinutes(15);
        return VisitorSession::where('last_activity', '>=', $cutoff)->count();
    }
}
