@extends('layouts.admin')

@section('title', "Edit Video: {$video->title}")

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.videos.index') }}" class="p-2 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Edit Hero Video Banner</h1>
            <p class="text-sm text-slate-400">Update video source, button link, and ordering</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400 text-sm">
            <div class="font-semibold mb-1">Please fix the errors below:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.videos.update', $video->id) }}" method="POST" class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">Banner Title *</label>
            <input type="text" name="title" value="{{ old('title', $video->title) }}" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
        </div>

        <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">Desktop Video URL (.mp4 / stream) *</label>
            <input type="text" name="video_url" value="{{ old('video_url', $video->video_url) }}" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white font-mono focus:border-amber-400 outline-none">
        </div>

        <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">Mobile Video URL (Optional)</label>
            <input type="text" name="mobile_video_url" value="{{ old('mobile_video_url', $video->mobile_video_url) }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white font-mono focus:border-amber-400 outline-none">
        </div>

        <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">Fallback Poster Image URL</label>
            <input type="text" name="poster_image" value="{{ old('poster_image', $video->poster_image) }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">CTA Button Text</label>
                <input type="text" name="cta_text" value="{{ old('cta_text', $video->cta_text) }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">CTA Destination URL</label>
                <input type="text" name="cta_url" value="{{ old('cta_url', $video->cta_url) }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $video->sort_order) }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
            </div>
            <div class="flex items-center pt-6">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $video->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-800 border-slate-700 text-amber-500">
                    <span class="text-sm font-medium text-slate-300">Set as active banner</span>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
            <a href="{{ route('admin.videos.index') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold rounded-lg transition">Cancel</a>
            <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 text-sm font-bold rounded-lg shadow-md transition">Update Banner</button>
        </div>
    </form>
</div>
@endsection
