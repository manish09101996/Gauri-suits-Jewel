@extends('layouts.admin')

@section('title', 'Add Shoppable Reel')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.reels.index') }}" class="p-2 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Add Shoppable Reel</h1>
            <p class="text-sm text-slate-400">Attach product pins to short vertical lookbook videos</p>
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

    <form action="{{ route('admin.reels.store') }}" method="POST" class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">Reel Title / Caption *</label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Royal Maroon Velvet Patiala Styling" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
        </div>

        <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">Video Stream URL (MP4 / WebM) *</label>
            <input type="text" name="video_url" value="{{ old('video_url') }}" required placeholder="https://cdn.example.com/reels/velvet_look.mp4" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white font-mono focus:border-amber-400 outline-none">
        </div>

        <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">Thumbnail Preview Image URL</label>
            <input type="text" name="thumbnail_url" value="{{ old('thumbnail_url') }}" placeholder="https://cdn.example.com/reels/thumb1.jpg" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
        </div>

        <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">Tagged Product for Instant Checkout</label>
            <select name="product_id" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                <option value="">-- No Product Pin (Inspirational Only) --</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>{{ $p->name }} (₹{{ number_format($p->sale_price ?? $p->base_price) }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">Custom Link URL (Optional override)</label>
            <input type="text" name="link_url" value="{{ old('link_url') }}" placeholder="/shop/category/bridal" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 1) }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
            </div>
            <div class="flex items-center pt-6">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-800 border-slate-700 text-amber-500">
                    <span class="text-sm font-medium text-slate-300">Set as live reel</span>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
            <a href="{{ route('admin.reels.index') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold rounded-lg transition">Cancel</a>
            <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 text-sm font-bold rounded-lg shadow-md transition">Publish Reel</button>
        </div>
    </form>
</div>
@endsection
