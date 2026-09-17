@extends('layouts.admin')

@section('title', 'Edit Hero Banner')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Edit Hero Banner #{{ $banner->id }}</h1>
            <p class="text-sm text-slate-400">Update headlines, texts, destination links, or change the banner image</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" target="_blank" class="text-xs text-[#C5A869] hover:underline font-semibold">
                Preview Storefront &rarr;
            </a>
            <a href="{{ route('admin.banners.index') }}" class="text-sm text-slate-400 hover:text-white transition">
                &larr; Back to Banners
            </a>
        </div>
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

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="bg-slate-900 border border-slate-800 rounded-xl p-6 sm:p-8 space-y-6 shadow-sm">
        @csrf
        @method('PUT')

        <!-- Current Banner Live Visual Preview -->
        <div class="p-4 bg-slate-950/60 rounded-xl border border-slate-800 space-y-3">
            <div class="text-xs font-bold uppercase tracking-wider text-[#D4AF37] flex items-center justify-between">
                <span>Current Live Banner Preview</span>
                <span class="text-slate-400 font-mono text-[11px]">Slide #{{ $banner->sort_order }}</span>
            </div>
            <div class="relative w-full aspect-[21/9] sm:aspect-[24/9] rounded-lg overflow-hidden border border-slate-700/80 shadow-md">
                <img src="{{ $banner->desktop_image_url }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent p-6 sm:p-8 flex flex-col justify-center">
                    <span class="text-[9px] sm:text-[10px] tracking-[0.3em] uppercase text-[#E6CA65] font-bold">
                        {{ $banner->kicker ?: 'TIMELESS TRADITIONS' }}
                    </span>
                    <h2 class="font-serif text-lg sm:text-2xl lg:text-3xl text-[#FAF7F2] font-bold uppercase leading-tight mt-1">
                        {{ $banner->title }}
                    </h2>
                    <p class="font-serif italic text-xs sm:text-sm text-[#E3CE9B] mt-1">
                        {{ $banner->subtitle ?: 'Punjabi Suits & Royal Jewels' }}
                    </p>
                    @if($banner->button_text)
                        <div class="mt-3">
                            <span class="inline-block px-3 py-1 border border-[#E6CA65] text-[#FAF7F2] text-[10px] font-bold tracking-widest uppercase bg-[#58111A]/80">
                                {{ $banner->button_text }} &rarr;
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Overline / Kicker & Headline Title -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Top Kicker / Overline
                </label>
                <input type="text" name="kicker" value="{{ old('kicker', $banner->kicker) }}" placeholder="e.g. TIMELESS TRADITIONS"
                       class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400">
                <span class="text-[11px] text-slate-500 mt-1 block">Gold uppercase text displayed above headline</span>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Headline Title *
                </label>
                <input type="text" name="title" value="{{ old('title', $banner->title) }}" required placeholder="e.g. HANDCRAFTED FOR TODAY"
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
                <input type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" placeholder="e.g. Punjabi Suits & Royal Jewels"
                       class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400 italic">
                <span class="text-[11px] text-slate-500 mt-1 block">Italic luxury subtitle under the headline</span>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Right Watermark Tagline
                </label>
                <input type="text" name="tagline" value="{{ old('tagline', $banner->tagline) }}" placeholder="e.g. Tradition Meets Elegance"
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
                <input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}" placeholder="e.g. SHOP NEW ARRIVALS"
                       class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Button Destination URL
                </label>
                <input type="text" name="link_url" value="{{ old('link_url', $banner->link_url) }}" placeholder="e.g. /shop/new-arrivals or /shop/suits"
                       class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400 font-mono">
            </div>
        </div>

        <!-- Banner Imagery Change -->
        <div class="space-y-4 pt-2 border-t border-slate-800">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#D4AF37]">Change Banner Image</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Desktop File Upload -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Upload New Desktop Image File
                    </label>
                    <input type="file" name="image_desktop_file" accept="image/jpeg,image/png,image/webp,image/jpg"
                           class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-300 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-400">
                    <span class="text-[11px] text-slate-500 mt-1 block">Leave empty to keep existing image</span>
                </div>

                <!-- Desktop Direct URL -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        OR Update Image URL
                    </label>
                    <input type="text" name="image_desktop_url" value="{{ old('image_desktop_url', $banner->image_desktop) }}" placeholder="https://..."
                           class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-400 font-mono">
                    <span class="text-[11px] text-slate-500 mt-1 block">Direct URL or storage path</span>
                </div>
            </div>

            <!-- Optional Mobile Image -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Upload New Mobile Image File
                    </label>
                    <input type="file" name="image_mobile_file" accept="image/jpeg,image/png,image/webp,image/jpg"
                           class="w-full bg-slate-800/80 border border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-300 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-slate-700 file:text-slate-200">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Mobile Image URL
                    </label>
                    <input type="text" name="image_mobile_url" value="{{ old('image_mobile_url', $banner->image_mobile) }}" placeholder="https://..."
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
                <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" min="1" max="99"
                       class="w-32 bg-slate-800/80 border border-slate-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-amber-400 font-mono">
                <span class="text-[11px] text-slate-500 mt-1 block">Order in the hero slider (1 = first slide)</span>
            </div>

            <div>
                <label class="flex items-center gap-3 cursor-pointer mt-4">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}
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
                Update Hero Banner
            </button>
        </div>
    </form>
</div>
@endsection