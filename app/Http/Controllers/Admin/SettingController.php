<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Banner;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::getAll();
        $announcement = Banner::where('type', 'announcement')->first();

        return view('admin.settings.index', compact('settings', 'announcement'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token', '_method', 'announcement_text', 'announcement_active', 'announcement_url']);

        foreach ($inputs as $key => $value) {
            Setting::set($key, $value);
        }

        // Announcement Bar
        if ($request->has('announcement_text')) {
            Banner::updateOrCreate(
                ['type' => 'announcement'],
                [
                    'title' => $request->input('announcement_text', 'FREE SHIPPING ON ORDERS ABOVE ₹2999'),
                    'link_url' => $request->input('announcement_url', '/shop'),
                    'image_desktop' => '',
                    'is_active' => $request->boolean('announcement_active', true),
                ]
            );
        }

        return back()->with('success', 'Store settings and configurations saved.');
    }
}
