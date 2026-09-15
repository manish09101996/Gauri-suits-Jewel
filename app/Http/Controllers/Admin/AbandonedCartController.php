<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbandonedCartController extends Controller
{
    public function index()
    {
        $cutoff = Carbon::now()->subHours(2);

        $abandonedCarts = Cart::has('items')
            ->where('updated_at', '<=', $cutoff)
            ->with(['user', 'items.product.images', 'items.variant'])
            ->latest('updated_at')
            ->paginate(15);

        return view('admin.abandoned-carts.index', compact('abandonedCarts'));
    }
}
