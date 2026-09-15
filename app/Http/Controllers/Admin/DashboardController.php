<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected AnalyticsService $analyticsService
    ) {}

    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $days = (int) $request->input('days', 30);

        $kpis = $this->analyticsService->getKpiMetrics($startDate, $endDate);
        $revenueChart = $this->analyticsService->getRevenueChartData($days);
        $topProducts = $this->analyticsService->getTopProducts(5);
        $categorySales = $this->analyticsService->getSalesByCategory();
        $orderStatuses = $this->analyticsService->getOrderStatusDistribution();
        $recentOrders = $this->analyticsService->getRecentOrders(7);
        $recentCustomers = $this->analyticsService->getRecentCustomers(5);
        $lowStockItems = $this->analyticsService->getLowStockItems(6);
        $liveVisitorsCount = $this->analyticsService->getLiveVisitorsCount();

        return view('admin.dashboard', compact(
            'kpis',
            'revenueChart',
            'topProducts',
            'categorySales',
            'orderStatuses',
            'recentOrders',
            'recentCustomers',
            'lowStockItems',
            'liveVisitorsCount',
            'days'
        ));
    }

    public function chartData(Request $request)
    {
        $days = (int) $request->input('days', 30);
        return response()->json($this->analyticsService->getRevenueChartData($days));
    }
}
