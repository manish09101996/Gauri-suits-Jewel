@extends('layouts.app')

@section('title', 'Privacy Policy | Gauri Suits & Jewel')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="border-b pb-4">
        <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Data Protection & Privacy</span>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-brand-charcoal mt-1">Privacy Policy</h1>
        <p class="text-xs text-stone-400 mt-1">Last Updated: September 2026</p>
    </div>

    <div class="prose prose-stone max-w-none text-xs sm:text-sm text-stone-700 space-y-6 leading-relaxed">
        <p>
            <strong>Gauri Suits & Jewel</strong> ("we", "our", or "us") is dedicated to safeguarding your personal data and upholding your digital privacy. This policy outlines how we gather, utilize, store, and shield your information when visiting or purchasing from our online atelier.
        </p>

        <h2 class="font-serif text-lg font-bold text-brand-charcoal pt-4">1. Information We Collect</h2>
        <ul class="list-disc list-inside space-y-2">
            <li><strong>Personal Identity:</strong> Your full name, email address, telephone contact, billing and physical shipping addresses.</li>
            <li><strong>Transactional Information:</strong> Payment method chosen, order summary, tracking details, and purchase history. Note: We do NOT store credit/debit card numbers or bank credentials on our servers; payments are processed securely via PCI-DSS compliant payment gateways (Razorpay).</li>
            <li><strong>Technical & Session Data:</strong> IP address, device specifications, browser environment, geographical region, and browsing behavior to personalize your tailoring experience.</li>
        </ul>

        <h2 class="font-serif text-lg font-bold text-brand-charcoal pt-4">2. How We Utilize Your Data</h2>
        <ul class="list-disc list-inside space-y-2">
            <li>To process and fulfill orders, courier dispatches, and provide live WhatsApp/SMS transit updates.</li>
            <li>To manage customer accounts, provide VIP bespoke styling consultations, and process legitimate returns.</li>
            <li>To deliver exclusive seasonal festive catalogues, private trunk show invites, and promotional coupon privileges (with your consent, easily opt-out anytime).</li>
            <li>To identify and prevent fraudulent transactions, chargebacks, or unauthorized access.</li>
        </ul>

        <h2 class="font-serif text-lg font-bold text-brand-charcoal pt-4">3. Data Security & Storage</h2>
        <p>
            We implement 256-bit SSL encryption, tokenized authentication, secure database credential vaults, and strict access governance. Your information is never sold, leased, or monetized to any external third parties.
        </p>

        <h2 class="font-serif text-lg font-bold text-brand-charcoal pt-4">4. Your Privacy Rights</h2>
        <p>
            Under prevailing Indian and global data privacy frameworks, you have the full entitlement to access, rectify, or request erasure of your personal data records held by us. Contact our Data Protection Officer at <a href="mailto:privacy@gaurisuits.com" class="text-brand-maroon underline font-bold">privacy@gaurisuits.com</a>.
        </p>
    </div>
</div>
@endsection
