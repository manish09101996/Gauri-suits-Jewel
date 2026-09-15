<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderService;
use App\Http\Requests\ManualOrderRequest;
use Illuminate\Support\Facades\Auth;

class ManualOrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    public function create()
    {
        $products = Product::published()->with('variants')->get();
        $customers = User::latest()->get();

        return view('admin.orders.create-manual', compact('products', 'customers'));
    }

    public function store(ManualOrderRequest $request)
    {
        $adminName = Auth::guard('admin')->user()->name ?? 'Admin';

        try {
            $order = $this->orderService->createManualOrder($request->validated(), $adminName);
            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', "Manual Order #{$order->order_number} created successfully.");
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
