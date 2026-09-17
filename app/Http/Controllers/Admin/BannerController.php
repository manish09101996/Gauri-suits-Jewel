<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order', 'asc')->orderBy('id', 'desc')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'kicker' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'tagline' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'link_url' => 'nullable|string|max:500',
            'image_desktop_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_desktop_url' => 'nullable|string|max:1000',
            'image_mobile_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_mobile_url' => 'nullable|string|max:1000',
            'type' => 'nullable|string|in:hero,promo,announcement,banner',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $imageDesktop = $validated['image_desktop_url'] ?? null;
        if ($request->hasFile('image_desktop_file')) {
            $imageDesktop = $request->file('image_desktop_file')->store('banners', 'public');
        }

        if (empty($imageDesktop)) {
            $imageDesktop = 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=85&w=2400&auto=format&fit=crop';
        }

        $imageMobile = $validated['image_mobile_url'] ?? null;
        if ($request->hasFile('image_mobile_file')) {
            $imageMobile = $request->file('image_mobile_file')->store('banners', 'public');
        }

        Banner::create([
            'title' => $validated['title'],
            'kicker' => $validated['kicker'] ?? 'TIMELESS TRADITIONS',
            'subtitle' => $validated['subtitle'] ?? 'Punjabi Suits & Royal Jewels',
            'tagline' => $validated['tagline'] ?? 'Tradition Meets Elegance',
            'button_text' => $validated['button_text'] ?? 'SHOP NEW ARRIVALS',
            'link_url' => $validated['link_url'] ?? '/shop/new-arrivals',
            'image_desktop' => $imageDesktop,
            'image_mobile' => $imageMobile,
            'type' => $validated['type'] ?? 'hero',
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 1,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Hero banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'kicker' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'tagline' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'link_url' => 'nullable|string|max:500',
            'image_desktop_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_desktop_url' => 'nullable|string|max:1000',
            'image_mobile_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_mobile_url' => 'nullable|string|max:1000',
            'type' => 'nullable|string|in:hero,promo,announcement,banner',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $imageDesktop = $banner->image_desktop;
        if ($request->hasFile('image_desktop_file')) {
            if ($imageDesktop && !str_starts_with($imageDesktop, 'http') && Storage::disk('public')->exists($imageDesktop)) {
                Storage::disk('public')->delete($imageDesktop);
            }
            $imageDesktop = $request->file('image_desktop_file')->store('banners', 'public');
        } elseif (!empty($validated['image_desktop_url'])) {
            $imageDesktop = $validated['image_desktop_url'];
        }

        $imageMobile = $banner->image_mobile;
        if ($request->hasFile('image_mobile_file')) {
            if ($imageMobile && !str_starts_with($imageMobile, 'http') && Storage::disk('public')->exists($imageMobile)) {
                Storage::disk('public')->delete($imageMobile);
            }
            $imageMobile = $request->file('image_mobile_file')->store('banners', 'public');
        } elseif (!empty($validated['image_mobile_url'])) {
            $imageMobile = $validated['image_mobile_url'];
        }

        $banner->update([
            'title' => $validated['title'],
            'kicker' => $validated['kicker'] ?? 'TIMELESS TRADITIONS',
            'subtitle' => $validated['subtitle'] ?? 'Punjabi Suits & Royal Jewels',
            'tagline' => $validated['tagline'] ?? 'Tradition Meets Elegance',
            'button_text' => $validated['button_text'] ?? 'SHOP NEW ARRIVALS',
            'link_url' => $validated['link_url'] ?? '/shop/new-arrivals',
            'image_desktop' => $imageDesktop,
            'image_mobile' => $imageMobile,
            'type' => $validated['type'] ?? 'hero',
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? $banner->sort_order,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Hero banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image_desktop && !str_starts_with($banner->image_desktop, 'http')) {
            Storage::disk('public')->delete($banner->image_desktop);
        }
        if ($banner->image_mobile && !str_starts_with($banner->image_mobile, 'http')) {
            Storage::disk('public')->delete($banner->image_mobile);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Hero banner deleted successfully.');
    }
}