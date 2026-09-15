<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use App\Models\ShippingRate;
use App\Models\Setting;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        $zones = ShippingZone::with('rates')->get();
        $freeShippingThreshold = Setting::get('free_shipping_threshold', 2999);
        $flatShippingRate = Setting::get('flat_shipping_rate', 150);
        $codEnabled = Setting::get('cod_enabled', '1');
        $codExtraFee = Setting::get('cod_extra_fee', 0);
        $codMinOrder = Setting::get('cod_min_order', 0);
        $codMaxOrder = Setting::get('cod_max_order', 25000);

        return view('admin.shipping.index', compact(
            'zones',
            'freeShippingThreshold',
            'flatShippingRate',
            'codEnabled',
            'codExtraFee',
            'codMinOrder',
            'codMaxOrder'
        ));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'free_shipping_threshold' => 'required|numeric|min:0',
            'flat_shipping_rate' => 'required|numeric|min:0',
            'cod_enabled' => 'required|boolean',
            'cod_extra_fee' => 'nullable|numeric|min:0',
            'cod_min_order' => 'nullable|numeric|min:0',
            'cod_max_order' => 'nullable|numeric|min:0',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'shipping');
        }

        return back()->with('success', 'Shipping rules and thresholds updated.');
    }

    public function storeZone(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'states_text' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $states = array_map('trim', explode(',', $validated['states_text']));

        ShippingZone::create([
            'name' => $validated['name'],
            'states' => array_filter($states),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Shipping zone added.');
    }

    public function storeRate(Request $request, ShippingZone $zone)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'min_order_amount' => 'required|numeric|min:0',
            'max_order_amount' => 'nullable|numeric|min:0',
            'rate' => 'required|numeric|min:0',
            'estimated_days' => 'nullable|string|max:50',
        ]);

        $zone->rates()->create($validated);

        return back()->with('success', 'Shipping rate created.');
    }

    public function destroyRate(ShippingRate $rate)
    {
        $rate->delete();
        return back()->with('success', 'Shipping rate deleted.');
    }
}
