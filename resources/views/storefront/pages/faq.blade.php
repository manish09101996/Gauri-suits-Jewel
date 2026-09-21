@extends('layouts.app')

@section('title', 'Frequently Asked Questions (FAQ) | Gauri Suits & Jewel')
@section('meta_description', 'Find answers about custom Punjabi suit stitching, international shipping times, Kundan jewellery certification, and returns at Gauri Suits & Jewel.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12" x-data="{ openFaq: null }">
    <div class="text-center space-y-2">
        <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Help & Clarity</span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold text-brand-charcoal">Frequently Asked Questions</h1>
        <p class="text-xs sm:text-sm text-stone-500 font-light max-w-xl mx-auto">
            Everything you need to know about our handcrafted Punjabi suits, custom measurements, worldwide delivery, and royal jewellery.
        </p>
    </div>

    <div class="space-y-4">
        @php
            $faqs = [
                [
                    'q' => 'How does custom stitching / made-to-measure tailoring work?',
                    'a' => 'When you select "Custom Made-to-Measure" for any salwar suit or anarkali, our master boutique stylist contacts you via WhatsApp or email within 24 hours of order placement. We share an easy-to-follow video measurement guide and record your custom kurti length, bust, waist, salwar flare, sleeve style, and neckline preferences.'
                ],
                [
                    'q' => 'Do you ship internationally outside India?',
                    'a' => 'Yes, Gauri Suits & Jewel ships worldwide to over 45 countries including USA, Canada, United Kingdom, Australia, New Zealand, UAE, and Europe via DHL Express and FedEx. Delivery typically takes 5 to 9 business days.'
                ],
                [
                    'q' => 'What fabrics do you use for your Punjabi suits?',
                    'a' => 'We pride ourselves on 100% natural, heritage fabrics: handloom Chanderi silk, pure Mulmul cotton, Banarasi brocades, organza, tissue silks, and micro-velvet. Every garment page clearly lists the fabric breakdown.'
                ],
                [
                    'q' => 'Is Cash on Delivery (COD) available?',
                    'a' => 'Yes, Cash on Delivery is available on orders up to $2,500. You can pay at your doorstep upon parcel receipt.'
                ],
                [
                    'q' => 'Is your jewellery authentic Kundan and Polki?',
                    'a' => 'Yes. Our jewellery is handcrafted by traditional artisans using semi-precious Kundan glass stones, high-grade brass/copper metal alloy bases, and micron 22K gold plating with protective lacquer coating to prevent tarnishing.'
                ],
                [
                    'q' => 'What is your return and exchange policy?',
                    'a' => 'We offer a hassle-free 7-day return policy on all standard unstitched suits and non-customized jewellery items. Due to the personalized nature of bespoke tailor-stitched garments, customized suits cannot be returned for cash refunds, but we provide complimentary alteration assistance.'
                ],
            ];
        @endphp

        @foreach($faqs as $idx => $faq)
        <div class="bg-white border border-stone-200 rounded-2xl overflow-hidden shadow-sm transition">
            <button type="button" @click="openFaq = (openFaq === {{ $idx }} ? null : {{ $idx }})" class="w-full p-6 text-left flex items-center justify-between gap-4">
                <span class="font-serif font-bold text-base sm:text-lg text-brand-charcoal">{{ $faq['q'] }}</span>
                <span class="text-stone-400 font-bold text-lg shrink-0" x-text="openFaq === {{ $idx }} ? '−' : '+'">+</span>
            </button>
            <div x-show="openFaq === {{ $idx }}" x-collapse class="px-6 pb-6 text-xs sm:text-sm text-stone-600 font-light leading-relaxed border-t border-stone-100 pt-4" style="display: none;">
                {{ $faq['a'] }}
            </div>
        </div>
        @endforeach
    </div>

    <!-- Contact Banner -->
    <div class="p-8 bg-stone-50 border border-stone-200 rounded-3xl text-center space-y-3">
        <h3 class="font-serif text-xl font-bold text-brand-charcoal">Have a question not listed here?</h3>
        <p class="text-xs text-stone-500 font-light">Our bridal stylists are online right now to guide your selection.</p>
        <div class="pt-2">
            <a href="https://wa.me/919876543210" target="_blank" class="inline-flex px-6 py-3 bg-brand-maroon hover:bg-[#400c13] text-white font-bold text-xs uppercase tracking-wider rounded transition">
                Chat on WhatsApp
            </a>
        </div>
    </div>
</div>
@endsection
