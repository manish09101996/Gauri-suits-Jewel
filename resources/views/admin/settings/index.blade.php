@extends('layouts.admin')

@section('title', 'Store Settings & Configuration')

@section('content')
<div class="space-y-6" x-data="{ tab: 'general' }">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">System & Brand Settings</h1>
            <p class="text-sm text-slate-400">Configure boutique identity, Razorpay gateway credentials, announcement ticker, and tax policies</p>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-800 pb-3">
        <button type="button" @click="tab = 'general'" :class="tab === 'general' ? 'bg-amber-500 text-slate-950 font-bold' : 'text-slate-400 hover:text-white bg-slate-800/60'" class="px-4 py-2 rounded-lg text-xs font-semibold transition">
            General & Brand
        </button>
        <button type="button" @click="tab = 'announcement'" :class="tab === 'announcement' ? 'bg-amber-500 text-slate-950 font-bold' : 'text-slate-400 hover:text-white bg-slate-800/60'" class="px-4 py-2 rounded-lg text-xs font-semibold transition">
            Announcement Bar
        </button>
        <button type="button" @click="tab = 'payments'" :class="tab === 'payments' ? 'bg-amber-500 text-slate-950 font-bold' : 'text-slate-400 hover:text-white bg-slate-800/60'" class="px-4 py-2 rounded-lg text-xs font-semibold transition">
            Razorpay & Payments
        </button>
        <button type="button" @click="tab = 'tax'" :class="tab === 'tax' ? 'bg-amber-500 text-slate-950 font-bold' : 'text-slate-400 hover:text-white bg-slate-800/60'" class="px-4 py-2 rounded-lg text-xs font-semibold transition">
            GST & Taxes
        </button>
        <button type="button" @click="tab = 'social'" :class="tab === 'social' ? 'bg-amber-500 text-slate-950 font-bold' : 'text-slate-400 hover:text-white bg-slate-800/60'" class="px-4 py-2 rounded-lg text-xs font-semibold transition">
            Social & Contact
        </button>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <!-- General Tab -->
        <div x-show="tab === 'general'" class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm space-y-5">
            <h2 class="text-base font-semibold text-white">Brand Identity & Boutique Store Info</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Store Name</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Gauri Suits & Jewel' }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Brand Tagline</label>
                    <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? 'Luxury Punjabi Couture & Fine Jewellery' }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Customer Support Email</label>
                    <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'contact@gaurisuits.com' }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Support Phone / Mobile</label>
                    <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '+91 98765 43210' }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Official WhatsApp Number (with country code)</label>
                    <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '919876543210' }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">GSTIN Registration Number</label>
                    <input type="text" name="gst_number" value="{{ $settings['gst_number'] ?? '03AAAAA0000A1Z5' }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white uppercase focus:border-amber-400 outline-none">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-slate-300 mb-1">Flagship Boutique Physical Address</label>
                    <textarea name="contact_address" rows="2" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">{{ $settings['contact_address'] ?? 'Heritage Arcade, Mall Road, Ludhiana, Punjab - 141001' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Announcement Bar Tab -->
        <div x-show="tab === 'announcement'" class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm space-y-5" style="display: none;">
            <h2 class="text-base font-semibold text-white">Storefront Header Announcement Bar</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Announcement Text / Promotion Notice</label>
                    <input type="text" name="announcement_text" value="{{ $announcement?->title ?? 'COMPLIMENTARY SHIPPING ON ORDERS OVER $299 | WORLDWIDE COUTURE DELIVERY' }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Announcement Click Link URL</label>
                    <input type="text" name="announcement_url" value="{{ $announcement?->link_url ?? '/shop' }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                </div>
                <div class="pt-2">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="announcement_active" value="1" {{ ($announcement?->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-800 border-slate-700 text-amber-500">
                        <span class="text-sm font-medium text-slate-300">Display announcement ticker on top of site</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Payments Tab -->
        <div x-show="tab === 'payments'" class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm space-y-5" style="display: none;">
            <h2 class="text-base font-semibold text-white">Razorpay Payment Gateway API Credentials</h2>
            <div class="p-4 bg-amber-500/10 border border-amber-500/20 rounded-xl text-xs text-amber-300/90 leading-relaxed mb-4">
                Enter your Razorpay Dashboard API keys. For testing in sandbox, use test keys starting with <code class="bg-slate-800 px-1 py-0.5 rounded text-amber-400">rzp_test_...</code>.
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Razorpay Key ID</label>
                    <input type="text" name="razorpay_key_id" value="{{ $settings['razorpay_key_id'] ?? env('RAZORPAY_KEY_ID', '') }}" placeholder="rzp_test_..." class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white font-mono focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Razorpay Key Secret</label>
                    <input type="password" name="razorpay_key_secret" value="{{ $settings['razorpay_key_secret'] ?? env('RAZORPAY_KEY_SECRET', '') }}" placeholder="••••••••••••••••" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white font-mono focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Razorpay Webhook Secret</label>
                    <input type="password" name="razorpay_webhook_secret" value="{{ $settings['razorpay_webhook_secret'] ?? env('RAZORPAY_WEBHOOK_SECRET', '') }}" placeholder="Secret string for validating webhooks" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white font-mono focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Store Base Currency</label>
                    <input type="text" name="currency" value="{{ $settings['currency'] ?? 'AUD' }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                </div>
            </div>
        </div>

        <!-- Tax Tab -->
        <div x-show="tab === 'tax'" class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm space-y-5" style="display: none;">
            <h2 class="text-base font-semibold text-white">GST / Indian Tax Regulations</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Standard Apparel & Jewellery GST (%)</label>
                    <input type="number" step="0.01" name="tax_rate" value="{{ $settings['tax_rate'] ?? 3 }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                    <p class="text-[11px] text-slate-500 mt-1">e.g. 3% for precious jewellery / 5% - 12% for suits.</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Pricing Tax Mode</label>
                    <select name="prices_include_tax" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                        <option value="1" {{ ($settings['prices_include_tax'] ?? '1') == '1' ? 'selected' : '' }}>Prices are Inclusive of GST (MRP)</option>
                        <option value="0" {{ ($settings['prices_include_tax'] ?? '1') == '0' ? 'selected' : '' }}>GST is added on checkout Subtotal</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Social Tab -->
        <div x-show="tab === 'social'" class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm space-y-5" style="display: none;">
            <h2 class="text-base font-semibold text-white">Social Media & Editorial Channels</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Instagram URL</label>
                    <input type="text" name="social_instagram" value="{{ $settings['social_instagram'] ?? 'https://instagram.com/gaurisuits' }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Facebook URL</label>
                    <input type="text" name="social_facebook" value="{{ $settings['social_facebook'] ?? 'https://facebook.com/gaurisuits' }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Pinterest Lookbook URL</label>
                    <input type="text" name="social_pinterest" value="{{ $settings['social_pinterest'] ?? 'https://pinterest.com/gaurisuits' }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">YouTube Channel URL</label>
                    <input type="text" name="social_youtube" value="{{ $settings['social_youtube'] ?? 'https://youtube.com/@gaurisuits' }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="px-8 py-3 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-xl shadow-lg transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Save All Settings
            </button>
        </div>
    </form>
</div>
@endsection
