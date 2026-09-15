<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('sort_order')->get();
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|string|max:500',
            'mobile_video_url' => 'nullable|string|max:500',
            'poster_image' => 'nullable|string|max:500',
            'cta_text' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        Video::create($validated);

        return redirect()->route('admin.videos.index')->with('success', 'Video banner created.');
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|string|max:500',
            'mobile_video_url' => 'nullable|string|max:500',
            'poster_image' => 'nullable|string|max:500',
            'cta_text' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $video->update($validated);

        return redirect()->route('admin.videos.index')->with('success', 'Video banner updated.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return back()->with('success', 'Video deleted.');
    }
}
