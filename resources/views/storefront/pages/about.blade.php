@extends('layouts.app')

@section('title', 'Our Heritage Story | Gauri Suits & Jewel')
@section('meta_description', 'Learn about Gauri Suits & Jewel, founded in Punjab to preserve the royal heritage of handcrafted Punjabi salwar suits and imperial jewellery.')

@section('content')
<div class="space-y-16 py-8">
    <!-- Hero Banner -->
    <div class="relative bg-brand-charcoal text-white py-24 sm:py-32 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40" style="background-image: url('https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1920&auto=format&fit=crop');"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-brand-charcoal via-brand-charcoal/80 to-transparent"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left space-y-4 max-w-2xl">
            <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">The Atelier & Legacy</span>
            <h1 class="font-serif text-4xl sm:text-6xl font-bold tracking-tight text-white leading-tight">
                Preserving Punjab's Royal Textile Heritage
            </h1>
            <p class="text-sm sm:text-base text-stone-300 font-light leading-relaxed">
                Founded in the historic textile heartland of Ludhiana, Gauri Suits & Jewel was born from a deep devotion to authentic Punjabi craftsmanship, intricate needlework, and heirloom adornment.
            </p>
        </div>
    </div>

    <!-- Editorial Story Narrative -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 font-serif text-stone-800 text-base sm:text-lg leading-relaxed">
        <div class="text-center space-y-2">
            <span class="text-xs font-sans uppercase tracking-widest text-brand-gold font-bold">Our Philosophy</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-brand-charcoal">Woven with Pride, Finished by Hand</h2>
            <div class="w-16 h-0.5 bg-brand-gold mx-auto"></div>
        </div>

        <p>
            In an era of fleeting fast fashion, <strong>Gauri Suits & Jewel</strong> stands as a sanctuary of timeless Indian craftsmanship. We honor centuries of Punjabi tailoring traditions—from the voluminous authentic Patiala salwar with its cascading pleats to regal Anarkalis cut from metres of hand-dyed organza and chanderi silk.
        </p>

        <p>
            Every motif embroidered onto our garments is an ode to Punjab's folklore and cultural grace: the vibrant warmth of Phulkari, the delicate glint of hand-sewn Dabka and Tilla, and the enduring luxury of velvet shawls bordered with antique gota patti.
        </p>

        <!-- Blockquote -->
        <div class="my-10 p-8 border-l-4 border-brand-maroon bg-stone-50 rounded-r-2xl italic text-brand-charcoal font-serif text-xl leading-relaxed">
            "A Punjabi suit is not merely an attire; it is an inheritance of dignity, celebrations, and festive memories passed down from mother to daughter across generations."
        </div>

        <h3 class="text-2xl font-bold text-brand-charcoal pt-4">The Royal Jewellery Vault</h3>
        <p>
            Our couture ensembles are perfected with authentic Kundan, Jadau, and Polki jewellery crafted by multi-generational metalsmiths. Each choker necklace, chandbali earring, and matha patti is engineered with artisanal precision, ensuring you look imperial on life's most unforgettable occasions.
        </p>
    </section>

    <!-- Atelier Pillars -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 py-12 border-t border-stone-200">
            <div class="text-center space-y-3 p-6 bg-stone-50 rounded-2xl">
                <div class="w-12 h-12 rounded-full bg-brand-maroon text-white font-serif font-bold text-lg flex items-center justify-center mx-auto">1</div>
                <h3 class="font-serif font-bold text-lg text-brand-charcoal">Master Karigars</h3>
                <p class="text-xs text-stone-600 font-light leading-relaxed">
                    Over 80 master artisans work in our ateliers, preserving needlepoint and weaving traditions that have flourished for generations.
                </p>
            </div>

            <div class="text-center space-y-3 p-6 bg-stone-50 rounded-2xl">
                <div class="w-12 h-12 rounded-full bg-brand-maroon text-white font-serif font-bold text-lg flex items-center justify-center mx-auto">2</div>
                <h3 class="font-serif font-bold text-lg text-brand-charcoal">Pure Natural Silks</h3>
                <p class="text-xs text-stone-600 font-light leading-relaxed">
                    We strictly use natural mulmul cottons, handloom chanderi, pure georgette, and heritage silks dyed using azo-free eco-friendly pigments.
                </p>
            </div>

            <div class="text-center space-y-3 p-6 bg-stone-50 rounded-2xl">
                <div class="w-12 h-12 rounded-full bg-brand-maroon text-white font-serif font-bold text-lg flex items-center justify-center mx-auto">3</div>
                <h3 class="font-serif font-bold text-lg text-brand-charcoal">Global Diaspora Delivery</h3>
                <p class="text-xs text-stone-600 font-light leading-relaxed">
                    From Ludhiana to London, Toronto, California, Melbourne, and Dubai, our couture pieces are shipped across 45+ countries with express insured courier.
                </p>
            </div>
        </div>
    </section>
</div>
@endsection
