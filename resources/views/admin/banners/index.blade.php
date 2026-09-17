@extends('layouts.admin')

@section('title', 'Hero Banners')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Homepage Hero Banners</h1>
            <p class="text-sm text-slate-400">Manage editorial banner slides, luxury headlines, imagery, and button links for the storefront hero section</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/5 hover:bg-white/10 text-[#C5A869] border border-[#C5A869]/30 rounded-lg text-xs font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Preview Homepage
            </a>
            <a href="{{ route('admin.banners.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#D4AF37] hover:bg-[#C5A869] text-slate-950 font-bold rounded-lg text-sm transition shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                + Add Hero Banner
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white">&times;</button>
        </div>
    @endif

    <!-- Banner Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-800/60 text-xs uppercase font-semibold text-slate-400 tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="px-5 py-4 w-16">Order</th>
                        <th class="px-5 py-4 w-44">Banner Image</th>
                        <th class="px-5 py-4">Editorial Headlines &amp; Copy</th>
                        <th class="px-5 py-4">Button &amp; Link</th>
                        <th class="px-5 py-4 w-28">Status</th>
                        <th class="px-5 py-4 text-right w-28">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($banners as $banner)
                    <tr class="hover:bg-slate-800/40 transition">
                        <!-- Order -->
                        <td class="px-5 py-4 font-mono font-bold text-[#D4AF37]">
                            #{{ $banner->sort_order }}
                        </td>

                        <!-- Thumbnail -->
                        <td class="px-5 py-4">
                            <div class="relative w-36 aspect-[16/9] bg-slate-800 rounded-lg overflow-hidden border border-slate-700 shadow-sm group">
                                <img src="{{ $banner->desktop_image_url }}"
                                     alt="{{ $banner->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @if($banner->image_mobile)
                                    <span class="absolute bottom-1 right-1 bg-black/70 text-[9px] text-amber-300 px-1 py-0.5 rounded font-mono">Mobile ✓</span>
                                @endif
                            </div>
                        </td>

                        <!-- Copy -->
                        <td class="px-5 py-4">
                            <div class="space-y-1">
                                <span class="text-[10px] font-bold tracking-[0.2em] text-[#D4AF37] uppercase bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20 inline-block">
                                    {{ $banner->kicker ?: 'TIMELESS TRADITIONS' }}
                                </span>
                                <div class="font-serif text-base font-bold text-white uppercase tracking-wide">
                                    {{ $banner->title }}
                                </div>
                                <div class="text-xs text-slate-400 italic">
                                    {{ $banner->subtitle ?: 'Punjabi Suits & Royal Jewels' }}
                                </div>
                                @if($banner->tagline)
                                    <div class="text-[11px] text-[#C5A869]/80 font-serif">
                                        Watermark: &ldquo;{{ $banner->tagline }}&rdquo;
                                    </div>
                                @endif
                            </div>
                        </td>

                        <!-- CTA -->
                        <td class="px-5 py-4">
                            @if($banner->button_text)
                                <div class="space-y-1">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-[#58111A] text-[#F7EED9] text-xs font-semibold border border-[#C5A869]/40">
                                        {{ $banner->button_text }} &rarr;
                                    </span>
                                    <div class="text-[11px] text-slate-400 truncate max-w-[200px] font-mono">
                                        {{ $banner->link_url ?: '/shop' }}
                                    </div>
                                </div>
                            @else
                                <span class="text-xs text-slate-500">No CTA Button</span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="px-5 py-4">
                            @if($banner->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> Hidden
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-5 py-4 text-right space-x-2">
                            <a href="{{ route('admin.banners.edit', $banner->id) }}"
                               class="p-2 hover:bg-slate-800 text-slate-400 hover:text-amber-400 rounded-lg transition inline-flex"
                               title="Edit Banner">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete this hero banner?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 hover:bg-slate-800 text-slate-400 hover:text-rose-400 rounded-lg transition inline-flex" title="Delete Banner">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            No hero banners found. <a href="{{ route('admin.banners.create') }}" class="text-[#D4AF37] underline font-semibold">Create the first banner</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection