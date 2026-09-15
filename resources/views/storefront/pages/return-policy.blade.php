@extends('layouts.app')

@section('title', 'Return & Exchange Policy | Gauri Suits & Jewel')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="border-b pb-4">
        <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Customer Satisfaction</span>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-brand-charcoal mt-1">Return & Exchange Policy</h1>
        <p class="text-xs text-stone-400 mt-1">Last Updated: September 2026</p>
    </div>

    <div class="prose prose-stone max-w-none text-xs sm:text-sm text-stone-700 space-y-6 leading-relaxed">
        <p>
            At <strong>Gauri Suits & Jewel</strong>, we take immense pride in crafting authentic Punjabi silhouettes and opulent jewellery pieces. Your complete delight is our foremost priority. If for any reason you are not completely enchanted with your purchase, we are here to assist with an effortless return or exchange process.
        </p>

        <h2 class="font-serif text-lg font-bold text-brand-charcoal pt-4">1. Eligibility Window</h2>
        <ul class="list-disc list-inside space-y-2">
            <li>You may request a return or size exchange within <strong>7 calendar days</strong> of parcel delivery.</li>
            <li>Items must be entirely unused, unworn, unwashed, unaltered, and scented-free with all original couture tags, security seals, designer dust bags, and brand boxes intact.</li>
            <li>An unboxing parcel video is highly recommended upon receipt to ensure expedited processing for transit damage or discrepancy claims.</li>
        </ul>

        <h2 class="font-serif text-lg font-bold text-brand-charcoal pt-4">2. Non-Returnable & Final Sale Items</h2>
        <ul class="list-disc list-inside space-y-2">
            <li><strong>Custom Made-to-Measure:</strong> Custom-stitched suits, bespoke bloused pieces, or customized lengths made specifically to your personal measurement specifications.</li>
            <li><strong>Intimate & Pierced Jewellery:</strong> For stringent hygiene protocols, pierced earrings and nose rings (nath) cannot be returned unless received defective or damaged.</li>
            <li><strong>Clearance / Final Sale:</strong> Promotional items marked explicitly as "Final Sale" or discounted during special seasonal festive flash sales.</li>
        </ul>

        <h2 class="font-serif text-lg font-bold text-brand-charcoal pt-4">3. Reverse Pickup & Return Logistics</h2>
        <p>
            We offer hassle-free reverse courier pickup across serviceable domestic pincodes in India. Our courier partner will arrive within 2–3 business days after your request approval. Please ensure the parcel is securely packed inside its original outer box.
        </p>

        <h2 class="font-serif text-lg font-bold text-brand-charcoal pt-4">4. How to Initiate a Return or Exchange</h2>
        <p>
            Initiating a request is simple and transparent:
        </p>
        <ol class="list-decimal list-inside space-y-2 pl-2">
            <li>Visit your <a href="{{ route('account.orders') }}" class="text-brand-maroon underline font-bold">Order History</a> under your Gauri account dashboard.</li>
            <li>Select the order and tap <em>Request Return / Exchange</em>.</li>
            <li>Alternatively, message our VIP Concierge directly on WhatsApp at <a href="https://wa.me/919876543210" target="_blank" class="text-brand-maroon underline font-bold">+91 98765 43210</a> or email <a href="mailto:care@gaurisuits.com" class="text-brand-maroon underline font-bold">care@gaurisuits.com</a> with your Order ID and photos.</li>
        </ol>
    </div>
</div>
@endsection
