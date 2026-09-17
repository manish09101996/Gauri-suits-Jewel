@extends('layouts.admin')

@section('title', 'Add Hero Banner')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Create Hero Banner</h1>
            <p class="text-sm text-slate-400">Design a royal editorial slide for the homepage hero section</p>
        </div>
        <a href="{{ route('admin.banners.index') }}" class="text-sm text-slate-400 hover:text-white transition">
            &larr; Back to Banners
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400 text-sm space-y-1">
            <div class="font-bold">Please check the required fields:</div>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="bg-slate-900 border border-slate-800 rounded-xl p-6 sm:p-8 space-y-6 shadow-sm">
        @csrf

        <!-- Top Overline / Kicker & Headline Title -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Top Kicker / Overline
                </label>
                <input type="text" name="kicker" value="{{ old('kicker', 'TIMELESS TRADITIONS') }}" placeholder="e.g. TIMELESS TRADITIONS"
                       class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400">
                <span class="text-[11px] text-slate-500 mt-1 block">Gold uppercase text displayed above headline</span>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Headline Title *
                </label>
                <input type="text" name="title" value="{{ old('title', 'HANDCRAFTED FOR TODAY') }}" required placeholder="e.g. HANDCRAFTED FOR TODAY"
                       class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400 font-serif">
                <span class="text-[11px] text-slate-500 mt-1 block">Main large serif title</span>
            </div>
        </div>

        <!-- Subtitle & Right Watermark Tagline -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Subtitle / Description
                </label>
                <input type="text" name="subtitle" value="{{ old('subtitle', 'Punjabi Suits & Royal Jewels') }}" placeholder="e.g. Punjabi Suits & Royal Jewels"
                       class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400 italic">
                <span class="text-[11px] text-slate-500 mt-1 block">Italic luxury subtitle under the headline</span>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Right Watermark Tagline
                </label>
                <input type="text" name="tagline" value="{{ old('tagline', 'Tradition Meets Elegance') }}" placeholder="e.g. Tradition Meets Elegance"
                       class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400 font-serif">
                <span class="text-[11px] text-slate-500 mt-1 block">Calligraphic italic text on the right side</span>
            </div>
        </div>

        <!-- CTA Button Text & Link -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2 border-t border-slate-800">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Button Text
                </label>
                <input type="text" name="button_text" value="{{ old('button_text', 'SHOP NEW ARRIVALS') }}" placeholder="e.g. SHOP NEW ARRIVALS"
                       class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Button Destination URL
                </label>
                <input type="text" name="link_url" value="{{ old('link_url', '/shop/new-arrivals') }}" placeholder="e.g. /shop/new-arrivals or /shop/suits"
                       class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400 font-mono">
            </div>
        </div>

        <!-- Banner Imagery -->
        <div class="space-y-4 pt-2 border-t border-slate-800">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#D4AF37]">Banner Imagery</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Desktop File Upload -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Upload Desktop Image File
                    </label>
                    <input type="file" name="image_desktop_file" accept="image/jpeg,image/png,image/webp,image/jpg"
                           class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-300 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-400">
                    <span class="text-[11px] text-slate-500 mt-1 block">Recommended resolution: 2400 &times; 1000 px</span>
                </div>

                <!-- Desktop Direct URL -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        OR Direct Image URL (Unsplash / CDN)
                    </label>
                    <input type="url" name="image_desktop_url" value="{{ old('image_desktop_url', 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=85&w=2400&auto=format&fit=crop') }}" placeholder="https://..."
                           class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-400 font-mono">
                    <span class="text-[11px] text-slate-500 mt-1 block">Used if no local file is selected</span>
                </div>
            </div>

            <!-- Optional Mobile Image -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Optional Mobile Image File
                    </label>
                    <input type="file" name="image_mobile_file" accept="image/jpeg,image/png,image/webp,image/jpg"
                           class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-300 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-slate-700 file:text-slate-200">
                    <span class="text-[11px] text-slate-500 mt-1 block">Portrait ratio optimized for phone screens</span>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        OR Mobile Image URL
                    </label>
                    <input type="url" name="image_mobile_url" value="{{ old('image_mobile_url') }}" placeholder="https://..."
                           class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-400 font-mono">
                </div>
            </div>
        </div>

        <!-- Settings: Sort Order & Active Toggle -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2 border-t border-slate-800 items-center">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Display Sort Order
                </label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 1) }}" min="1" max="99"
                       class="w-32 bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-amber-400 font-mono">
                <span class="text-[11px] text-slate-500 mt-1 block">Order in the hero slider (1 = first slide)</span>
            </div>

            <div>
                <label class="flex items-center gap-3 cursor-pointer mt-4">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-slate-700 text-amber-500 focus:ring-0 focus:ring-offset-0 bg-slate-800">
                    <span class="text-sm font-semibold text-white">Publish to Homepage (Active)</span>
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-6 border-t border-slate-800 flex items-center justify-end gap-4">
            <a href="{{ route('admin.banners.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-700 text-slate-300 hover:text-white hover:bg-slate-800 transition text-sm">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 bg-[#D4AF37] hover:bg-[#C5A869] text-slate-950 font-bold rounded-lg text-sm transition shadow-lg flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Save &amp; Publish Hero Banner
            </button>
        </div>
    </form>
</div>
@endsection