@extends('layouts.app')

@section('title', 'Refund & Cancellation Policy | Gauri Suits & Jewel')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="border-b pb-4">
        <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Financial Trust</span>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-brand-charcoal mt-1">Refund & Cancellation Policy</h1>
        <p class="text-xs text-stone-400 mt-1">Last Updated: September 2026</p>
    </div>

    <div class="prose prose-stone max-w-none text-xs sm:text-sm text-stone-700 space-y-6 leading-relaxed">
        <p>
            At <strong>Gauri Suits & Jewel</strong>, we value the trust you place in our artisanal creations. Our refund process is designed to be swift, transparent, and respectful of your convenience.
        </p>

        <h2 class="font-serif text-lg font-bold text-brand-charcoal pt-4">1. Order Cancellation Policy</h2>
        <p>
            You may cancel an order free of charge prior to its handover to logistics or the cutting stage of custom tailoring:
        </p>
        <ul class="list-disc list-inside space-y-2">
            <li><strong>Ready-to-Ship Orders:</strong> Can be cancelled within <strong>12 hours</strong> of placement or before courier dispatch, whichever occurs first.</li>
            <li><strong>Bespoke / Made-to-Measure Orders:</strong> Can be cancelled within <strong>6 hours</strong> of order confirmation before fabric cutting and embroidery commences.</li>
            <li>Once dispatched, orders cannot be cancelled directly and must follow our standard 7-day return procedure upon delivery.</li>
        </ul>

        <h2 class="font-serif text-lg font-bold text-brand-charcoal pt-4">2. Refund Processing & Timelines</h2>
        <p>
            Once your returned package arrives at our quality audit warehouse in Punjab, our experts inspect the integrity of tags and fabrics within 48 business hours. Upon successful verification:
        </p>
        <ul class="list-disc list-inside space-y-2">
            <li><strong>Prepaid Orders (UPI, Net Banking, Credit/Debit Cards, Razorpay):</strong> Refunds are credited directly back to the original source account within <strong>5 to 7 business days</strong> as per banking turnaround schedules.</li>
            <li><strong>Cash on Delivery (COD):</strong> You may opt for an instant Store Credit Gift Card (valid for 12 months) or a direct NEFT/IMPS bank transfer upon providing beneficiary bank account details.</li>
        </ul>

        <h2 class="font-serif text-lg font-bold text-brand-charcoal pt-4">3. Damaged or Defective Consignments</h2>
        <p>
            Each garment and jewellery ensemble undergoes a rigorous three-step quality audit prior to packaging. In the rare event that an item is received with a transit defect or manufacturing fault, please notify us within <strong>48 hours</strong> of receipt along with unboxing photographs or video. We will promptly issue an expedited full replacement or 100% refund including all shipping surcharges.
        </p>
    </div>
</div>
@endsection
