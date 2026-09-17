@extends('layouts.admin')

@section('title', 'Shoppable Reels & Stories')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Shoppable Reels & Videos</h1>
            <p class="text-sm text-slate-400">Manage interactive vertical reels with direct product tagging and 'Buy Now' pins</p>
        </div>
        <a href="{{ route('admin.reels.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 font-semibold rounded-lg text-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Reel
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($reels as $reel)
        <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-sm flex flex-col group">
            <div class="relative aspect-[9/16] bg-slate-800 overflow-hidden">
                @if($reel->thumbnail_url)
                    <img src="{{ $reel->thumbnail_url }}" alt="{{ $reel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-500">
                        <svg class="w-10 h-10 text-slate-600 mb-2" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 6l-5-3.5v7l5-3.5z"/></svg>
                        <span class="text-xs">No Thumbnail</span>
                    </div>
                @endif
                <div class="absolute top-3 left-3">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold tracking-wider uppercase {{ $reel->is_active ? 'bg-emerald-500/90 text-white' : 'bg-slate-800/90 text-slate-300' }}">
                        {{ $reel->is_active ? 'LIVE' : 'HIDDEN' }}
                    </span>
                </div>
                <div class="absolute top-3 right-3 bg-slate-950/80 text-amber-400 text-xs font-mono px-2 py-0.5 rounded">
                    #{{ $reel->sort_order }}
                </div>
                @if($reel->product)
                    <div class="absolute bottom-3 left-3 right-3 bg-slate-950/90 backdrop-blur border border-slate-700/60 p-2 rounded-lg flex items-center gap-2">
                        <div class="w-7 h-7 rounded bg-slate-800 overflow-hidden shrink-0">
                            @if($reel->product->primary_image_url)
                                <img src="{{ $reel->product->primary_image_url }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-[11px] font-bold text-white truncate">{{ $reel->product->name }}</div>
                            <div class="text-[10px] text-amber-400 font-bold">₹{{ number_format($reel->product->sale_price ?? $reel->product->base_price) }}</div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="p-4 flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-white text-sm line-clamp-1 mb-1">{{ $reel->title }}</h3>
                    <p class="text-xs text-slate-400 truncate font-mono">{{ $reel->video_url }}</p>
                </div>

                <div class="flex items-center justify-between pt-3 border-t border-slate-800 mt-3">
                    <a href="{{ route('admin.reels.edit', $reel->id) }}" class="text-xs text-amber-400 hover:text-amber-300 font-semibold">
                        Edit Reel
                    </a>
                    <form action="{{ route('admin.reels.destroy', $reel->id) }}" method="POST" onsubmit="return confirm('Delete this reel?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-rose-400 hover:text-rose-300">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-slate-900 border border-slate-800 rounded-xl p-12 text-center text-slate-500">
            No reels added yet. Click "Add Reel" to feature shoppable Instagram-style short videos.
        </div>
        @endforelse
    </div>
</div>
@endsection
