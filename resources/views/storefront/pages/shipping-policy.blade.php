@extends('layouts.app')

@section('title', 'Shipping & Delivery Policy | Gauri Suits & Jewel')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="border-b pb-4">
        <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Policy & Transit</span>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-brand-charcoal mt-1">Shipping & Delivery Policy</h1>
        <p class="text-xs text-stone-400 mt-1">Last Updated: September 2026</p>
    </div>

    <div class="prose prose-stone max-w-none text-xs sm:text-sm text-stone-700 space-y-6 leading-relaxed">
        <h2 class="font-serif text-lg font-bold text-brand-charcoal">1. Domestic Shipping Across India</h2>
        <p>
            At <strong>Gauri Suits & Jewel</strong>, we provide insured, express shipping to all serviceable postal pincodes throughout India via premier logistics partners including Delhivery, BlueDart, DTDC, and Speed Post.
        </p>
        <ul class="list-disc list-inside space-y-1">
            <li><strong>Complimentary Free Shipping:</strong> All domestic orders valued at ₹2,999 or above automatically receive free express delivery.</li>
            <li><strong>Standard Flat Courier Charge:</strong> A nominal flat fee of ₹150 applies to domestic orders below ₹2,999.</li>
            <li><strong>Dispatch Timeline:</strong> Ready-to-wear and unstitched fabric ensembles are dispatched within 24 to 48 business hours. Custom made-to-measure stitched orders require 5 to 7 working days for master tailoring before dispatch.</li>
            <li><strong>Transit Duration:</strong> Metro cities (Delhi NCR, Chandigarh, Mumbai, Bangalore): 2–3 business days. Rest of India: 3–5 business days.</li>
        </ul>

        <h2 class="font-serif text-lg font-bold text-brand-charcoal pt-4">2. International Shipping</h2>
        <p>
            We ship worldwide to USA, Canada, UK, Australia, UAE, Singapore, New Zealand, and 40+ countries via DHL Express and FedEx International. International courier rates are calculated at checkout based on destination country and volumetric parcel weight.
        </p>

        <h2 class="font-serif text-lg font-bold text-brand-charcoal pt-4">3. Tracking Your Consignment</h2>
        <p>
            As soon as your parcel is handed to the courier partner, an automated confirmation containing the Airway Bill (AWB) tracking number and courier tracking link is sent via SMS, WhatsApp, and Email. You can also track your shipment live using our <a href="{{ route('order.track') }}" class="text-brand-maroon underline font-bold">Order Tracking portal</a>.
        </p>
    </div>
</div>
@endsection
