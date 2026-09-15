@extends('layouts.app')

@section('title', 'Contact Us & Boutique Concierge | Gauri Suits & Jewel')
@section('meta_description', 'Connect with Gauri Suits & Jewel. Visit our flagship boutique in Ludhiana, Punjab or reach out to our bridal concierge via WhatsApp and email.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <div class="text-center max-w-2xl mx-auto space-y-2">
        <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Personal Assistance</span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold text-brand-charcoal">Get in Touch</h1>
        <p class="text-xs sm:text-sm text-stone-500 font-light">
            Whether you need custom bridal tailoring advice, order status support, or private boutique appointments, our team is at your service.
        </p>
    </div>

    @if(session('success'))
        <div class="max-w-2xl mx-auto p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs sm:text-sm font-semibold text-center">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="max-w-2xl mx-auto p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        <!-- Boutique Info (5 Cols) -->
        <div class="lg:col-span-5 bg-white border border-stone-200 rounded-2xl p-8 shadow-sm space-y-6">
            <div class="space-y-1">
                <span class="text-xs uppercase font-bold tracking-widest text-brand-gold">Flagship Store</span>
                <h2 class="font-serif text-2xl font-bold text-brand-charcoal">Gauri Suits & Jewel</h2>
            </div>

            <div class="space-y-4 text-xs sm:text-sm text-stone-600">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-brand-maroon shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <div>
                        <strong>Flagship Atelier Address:</strong><br>
                        Heritage Arcade, Mall Road,<br>
                        Ludhiana, Punjab - 141001, India
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-brand-maroon shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <div>
                        <strong>Phone:</strong> +91 98765 43210
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-brand-maroon shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <div>
                        <strong>Email:</strong> contact@gaurisuits.com
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-brand-maroon shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <strong>Boutique Timings:</strong><br>
                        Monday – Saturday: 10:30 AM – 8:30 PM IST<br>
                        Sunday: 11:30 AM – 7:00 PM IST
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-stone-100">
                <a href="https://wa.me/919876543210" target="_blank" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-widest rounded transition flex items-center justify-center gap-2 shadow">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.861.174.086.275.072.376-.044.102-.115.434-.506.549-.679.116-.173.232-.145.39-.087s1.011.477 1.184.564.289.13.332.203c.043.072.043.419-.101.824z"/></svg>
                    Direct WhatsApp Stylist Line
                </a>
            </div>
        </div>

        <!-- Contact Form (7 Cols) -->
        <div class="lg:col-span-7 bg-white border border-stone-200 rounded-2xl p-8 shadow-sm space-y-6">
            <div class="space-y-1">
                <span class="text-xs uppercase font-bold tracking-widest text-brand-gold">Inquiry Form</span>
                <h2 class="font-serif text-2xl font-bold text-brand-charcoal">Send Us a Message</h2>
            </div>

            <form action="{{ route('pages.contact.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-stone-700 mb-1">Your Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Navjot Kaur" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                    </div>

                    <div>
                        <label class="block font-bold text-stone-700 mb-1">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="navjot@example.com" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-stone-700 mb-1">Phone / WhatsApp</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+91 98765 43210" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                    </div>

                    <div>
                        <label class="block font-bold text-stone-700 mb-1">Inquiry Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Bridal trousseau / custom sizing" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-stone-700 mb-1">Message *</label>
                    <textarea name="message" rows="5" required placeholder="Describe your question, suit design preference, or wedding dates..." class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="w-full py-3.5 bg-brand-maroon hover:bg-[#400c13] text-white font-bold uppercase tracking-widest rounded shadow transition">
                    Send Inquiry
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
