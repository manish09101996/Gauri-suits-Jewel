<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reel;
use App\Models\Product;
use Illuminate\Http\Request;

class ReelController extends Controller
{
    public function index()
    {
        $reels = Reel::with('product')->orderBy('sort_order')->get();
        return view('admin.reels.index', compact('reels'));
    }

    public function create()
    {
        $products = Product::published()->get();
        return view('admin.reels.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|string|max:500',
            'thumbnail_url' => 'nullable|string|max:500',
            'product_id' => 'nullable|exists:products,id',
            'link_url' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        Reel::create($validated);

        return redirect()->route('admin.reels.index')->with('success', 'Reel added.');
    }

    public function edit(Reel $reel)
    {
        $products = Product::published()->get();
        return view('admin.reels.edit', compact('reel', 'products'));
    }

    public function update(Request $request, Reel $reel)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|string|max:500',
            'thumbnail_url' => 'nullable|string|max:500',
            'product_id' => 'nullable|exists:products,id',
            'link_url' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $reel->update($validated);

        return redirect()->route('admin.reels.index')->with('success', 'Reel updated.');
    }

    public function destroy(Reel $reel)
    {
        $reel->delete();
        return back()->with('success', 'Reel deleted.');
    }
}
