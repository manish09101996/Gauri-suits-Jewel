@extends('layouts.app')

@section('title', "{$product->name} | Gauri Suits & Jewel")
@section('meta_description', $product->short_description ?: Str::limit(strip_tags($product->description), 160))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-16"
     x-data="{
        activeImage: '{{ $product->primary_image_url }}',
        selectedVariantId: '{{ $product->variants->first()?->id ?? '' }}',
        selectedSize: '{{ $product->variants->first()?->size ?? 'Standard' }}',
        selectedPrice: {{ $product->effective_price }},
        quantity: 1,
        activeTab: 'desc',
        sizeGuideOpen: false,
        reviewModalOpen: false,
        variants: {{ json_encode($product->variants) }},
        selectVariant(v) {
            this.selectedVariantId = v.id;
            this.selectedSize = v.size || v.name || 'Standard';
            this.selectedPrice = v.price || {{ $product->effective_price }};
        },
        addToCart(redirectCheckout = false) {
            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: {{ $product->id }},
                    variant_id: this.selectedVariantId || null,
                    quantity: this.quantity
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (redirectCheckout) {
                        window.location.href = '{{ route('checkout.index') }}';
                    } else {
                        window.dispatchEvent(new CustomEvent('cart-updated', { detail: data }));
                        window.dispatchEvent(new CustomEvent('open-cart-drawer'));
                    }
                } else {
                    alert(data.message || 'Error adding item to bag.');
                }
            })
            .catch(err => console.error(err));
        }
     }">

    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-stone-400 uppercase tracking-wider">
        <a href="{{ route('home') }}" class="hover:text-brand-maroon transition">Home</a>
        <span>/</span>
        <a href="{{ route('shop.index') }}" class="hover:text-brand-maroon transition">Shop</a>
        @if($product->category)
            <span>/</span>
            <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-brand-maroon transition">{{ $product->category->name }}</a>
        @endif
        <span>/</span>
        <span class="text-brand-charcoal font-semibold truncate max-w-xs">{{ $product->name }}</span>
    </nav>

    <!-- Product Top Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14">
        <!-- Gallery Viewport (7 Cols on desktop) -->
        <div class="lg:col-span-7 space-y-4">
            <div class="relative aspect-[3/4] bg-stone-100 rounded-2xl overflow-hidden border border-stone-200 shadow-sm">
                <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-full object-cover object-top transition duration-500">

                <button type="button"
                        @click="toggleWishlist({{ $product->id }})"
                        :class="isInWishlist({{ $product->id }}) ? 'text-rose-500 bg-white' : 'text-stone-700 bg-white/80 hover:bg-white'"
                        class="absolute top-4 right-4 w-10 h-10 rounded-full backdrop-blur shadow-md flex items-center justify-center transition">
                    <svg class="w-5 h-5" :fill="isInWishlist({{ $product->id }}) ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </button>

                @if($product->discount_percent > 0)
                    <span class="absolute top-4 left-4 px-3 py-1 bg-brand-maroon text-white font-bold text-xs uppercase tracking-wider rounded-sm shadow">
                        {{ $product->discount_percent }}% OFF
                    </span>
                @endif
            </div>

            <!-- Thumbnail Grid -->
            @if($product->images->count() > 1)
            <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-none">
                @foreach($product->images as $img)
                @php
                    $imgUrl = str_starts_with($img->image_path, 'http') ? $img->image_path : asset('storage/' . $img->image_path);
                @endphp
                <button type="button"
                        @click="activeImage = '{{ $imgUrl }}'"
                        :class="activeImage === '{{ $imgUrl }}' ? 'border-brand-maroon ring-2 ring-brand-maroon/20' : 'border-stone-200 hover:border-stone-400'"
                        class="w-20 sm:w-24 aspect-[3/4] rounded-lg overflow-hidden border-2 shrink-0 transition">
                    <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Purchase Information (5 Cols on desktop) -->
        <div class="lg:col-span-5 space-y-6">
            <div>
                @if($product->category)
                    <div class="text-xs uppercase font-bold tracking-widest text-brand-gold mb-1">
                        {{ $product->category->name }}
                    </div>
                @endif
                <h1 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-brand-charcoal leading-tight">
                    {{ $product->name }}
                </h1>
                <div class="text-xs text-stone-400 font-mono mt-1">SKU: {{ $product->sku }}</div>
            </div>

            <!-- Ratings -->
            <div class="flex items-center gap-3">
                <div class="flex items-center text-amber-500">
                    @php $avgRating = $product->average_rating; @endphp
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= $avgRating ? 'fill-current' : 'text-stone-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <a href="#reviews" class="text-xs text-stone-500 hover:text-brand-maroon underline font-medium">
                    {{ $product->reviews_count }} {{ Str::plural('Customer Review', $product->reviews_count) }}
                </a>
            </div>

            <!-- Price Breakdown -->
            <div class="p-4 bg-stone-50 rounded-xl border border-stone-200/70 space-y-1">
                <div class="flex items-baseline gap-3">
                    <span class="font-serif text-3xl font-bold text-brand-maroon" x-text="'₹' + Number(selectedPrice).toLocaleString('en-IN')">
                        ₹{{ number_format($product->effective_price) }}
                    </span>
                    @if($product->compare_at_price)
                        <span class="text-base text-stone-400 line-through">
                            ₹{{ number_format($product->compare_at_price) }}
                        </span>
                    @endif
                </div>
                <p class="text-[11px] text-stone-500">Inclusive of all Indian taxes (GST) • Complimentary delivery on ₹2,999+</p>
            </div>

            <!-- Variant Picker (Sizes / Stitching) -->
            @if($product->variants->isNotEmpty())
            <div class="space-y-2.5">
                <div class="flex items-center justify-between">
                    <span class="text-xs uppercase font-bold tracking-wider text-brand-charcoal">
                        Select Sizing / Stitching: <span class="text-brand-maroon" x-text="selectedSize"></span>
                    </span>
                    <button type="button" @click="sizeGuideOpen = true" class="text-xs text-brand-gold hover:underline font-semibold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Size Guide
                    </button>
                </div>

                <div class="flex flex-wrap gap-2.5">
                    @foreach($product->variants as $variant)
                    <button type="button"
                            @click="selectVariant({{ json_encode($variant) }})"
                            :class="selectedVariantId == {{ $variant->id }} ? 'bg-[#58111A] text-[#F7EED9] border-2 border-[#D4AF37] shadow-sm' : 'bg-white text-stone-700 border-stone-300 hover:border-[#58111A]'"
                            class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-xs border transition">
                        {{ $variant->size ?: $variant->name ?: 'Standard' }}
                    </button>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Quantity Selector & Action Buttons -->
            <div class="space-y-3 pt-2">
                <div class="flex items-center gap-3">
                    <div class="flex items-center border border-stone-300 rounded-xs bg-white">
                        <button type="button" @click="quantity = Math.max(1, quantity - 1)" class="px-3 py-2 text-stone-600 hover:bg-stone-100 font-bold">-</button>
                        <span class="px-4 py-2 text-xs font-bold text-brand-charcoal" x-text="quantity">1</span>
                        <button type="button" @click="quantity = quantity + 1" class="px-3 py-2 text-stone-600 hover:bg-stone-100 font-bold">+</button>
                    </div>

                    <button type="button"
                            @click="addToCart(false)"
                            class="flex-1 py-3.5 bg-[#58111A] hover:bg-[#3B0A11] border border-[#D4AF37]/50 text-[#F7EED9] font-bold text-xs uppercase tracking-[0.2em] rounded-xs shadow-md transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Add to Bag
                    </button>
                </div>

                <button type="button"
                        @click="addToCart(true)"
                        class="w-full py-3.5 bg-gradient-to-r from-[#D4AF37] via-[#E6CA65] to-[#C5A869] hover:brightness-105 text-[#2A1810] font-bold text-xs uppercase tracking-[0.2em] rounded-xs shadow-md transition border border-[#D4AF37]">
                    Buy It Now (Express Checkout)
                </button>

                <!-- WhatsApp Stylist CTA (Royal Emerald Green) -->
                <a href="{{ $whatsappUrl }}" target="_blank" class="w-full py-3 border border-[#D4AF37]/30 bg-[#0A3828] hover:bg-[#083323] text-white font-bold text-xs uppercase tracking-[0.2em] rounded-xs transition flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4 fill-current text-[#25D366]" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.861.174.086.275.072.376-.044.102-.115.434-.506.549-.679.116-.173.232-.145.39-.087s1.011.477 1.184.564.289.13.332.203c.043.072.043.419-.101.824z"/></svg>
                    Consult Stylist on WhatsApp
                </a>
            </div>

            <!-- Guarantee Badges -->
            <div class="grid grid-cols-2 gap-3 pt-4 border-t border-stone-200 text-xs text-stone-600">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>100% Handcrafted Certified</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>7 Days Easy Returns</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Express Worldwide Delivery</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Cash on Delivery Available</span>
                </div>
            </div>

            <!-- Tabs: Description, Fabric & Care, Delivery -->
            <div class="pt-6 border-t border-stone-200">
                <div class="flex border-b border-stone-200 text-xs uppercase font-bold tracking-wider text-stone-500">
                    <button type="button" @click="activeTab = 'desc'" :class="activeTab === 'desc' ? 'border-b-2 border-brand-maroon text-brand-charcoal' : ''" class="pb-3 px-3">Description</button>
                    <button type="button" @click="activeTab = 'fabric'" :class="activeTab === 'fabric' ? 'border-b-2 border-brand-maroon text-brand-charcoal' : ''" class="pb-3 px-3">Fabric & Care</button>
                    <button type="button" @click="activeTab = 'shipping'" :class="activeTab === 'shipping' ? 'border-b-2 border-brand-maroon text-brand-charcoal' : ''" class="pb-3 px-3">Shipping & Returns</button>
                </div>

                <div class="py-4 text-xs sm:text-sm text-stone-600 leading-relaxed">
                    <div x-show="activeTab === 'desc'" class="space-y-2">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                    <div x-show="activeTab === 'fabric'" class="space-y-2" style="display: none;">
                        <p><strong>Fabric:</strong> {{ $product->fabric ?: 'Pure Chanderi Silk / Organza' }}</p>
                        <p><strong>Embroidery / Work:</strong> {{ $product->work ?: 'Intricate Zardozi & Tilla Handwork' }}</p>
                        <p><strong>Care Instructions:</strong> {{ $product->care_instructions ?: 'Dry clean only to maintain the lustre of delicate fabrics and metallic threads.' }}</p>
                    </div>
                    <div x-show="activeTab === 'shipping'" class="space-y-2" style="display: none;">
                        <p>Complimentary insured shipping across India for orders above ₹2,999. Standard delivery takes 3 to 5 business days.</p>
                        <p>International courier via DHL/FedEx takes 7 to 10 days. Easy returns and exchanges within 7 days of delivery.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Reviews Section -->
    <section id="reviews" class="pt-12 border-t border-stone-200 space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Client Experiences</span>
                <h2 class="font-serif text-2xl sm:text-3xl font-bold text-brand-charcoal">
                    Verified Customer Reviews
                </h2>
            </div>
            <button type="button" @click="reviewModalOpen = true" class="px-5 py-2.5 border border-brand-maroon text-brand-maroon hover:bg-brand-maroon hover:text-white font-bold text-xs uppercase tracking-wider rounded transition">
                Write a Review
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($product->approvedReviews as $rev)
            <div class="bg-stone-50 border border-stone-200/80 rounded-xl p-5 space-y-3">
                <div class="flex items-center gap-1 text-amber-500">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-3.5 h-3.5 {{ $i <= $rev->rating ? 'fill-current' : 'text-stone-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                @if($rev->title)
                    <h4 class="font-serif font-bold text-sm text-brand-charcoal">{{ $rev->title }}</h4>
                @endif
                <p class="text-xs text-stone-600 leading-relaxed">{{ $rev->comment }}</p>
                <div class="pt-2 border-t border-stone-200/60 flex items-center justify-between text-[11px]">
                    <span class="font-bold text-brand-charcoal">{{ $rev->author_name }}</span>
                    <span class="text-emerald-600 font-semibold">Verified Buyer</span>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-8 text-stone-400 text-xs">
                Be the first to review this royal ensemble!
            </div>
            @endforelse
        </div>
    </section>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
    <section class="pt-12 border-t border-stone-200 space-y-8">
        <div>
            <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Complete Your Look</span>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-brand-charcoal">
                You May Also Admire
            </h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-5 sm:gap-7">
            @foreach($relatedProducts as $relProduct)
                @include('storefront.partials.product-card', ['product' => $relProduct])
            @endforeach
        </div>
    </section>
    @endif

    <!-- Size Guide Modal -->
    <div x-show="sizeGuideOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
        <div @click.away="sizeGuideOpen = false" class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
            <div class="flex items-center justify-between border-b pb-3">
                <h3 class="font-serif text-lg font-bold text-brand-charcoal">Punjabi Suits Size Guide (Inches)</h3>
                <button type="button" @click="sizeGuideOpen = false" class="text-stone-400 hover:text-stone-700">✕</button>
            </div>
            <div class="overflow-x-auto text-xs text-stone-700">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-stone-100 font-bold">
                            <th class="p-2 border">Size</th>
                            <th class="p-2 border">Bust</th>
                            <th class="p-2 border">Waist</th>
                            <th class="p-2 border">Hip</th>
                            <th class="p-2 border">Kurti Length</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="p-2 border font-bold">XS</td><td class="p-2 border">34"</td><td class="p-2 border">28"</td><td class="p-2 border">36"</td><td class="p-2 border">42"</td></tr>
                        <tr><td class="p-2 border font-bold">S</td><td class="p-2 border">36"</td><td class="p-2 border">30"</td><td class="p-2 border">38"</td><td class="p-2 border">42"</td></tr>
                        <tr><td class="p-2 border font-bold">M</td><td class="p-2 border">38"</td><td class="p-2 border">32"</td><td class="p-2 border">40"</td><td class="p-2 border">43"</td></tr>
                        <tr><td class="p-2 border font-bold">L</td><td class="p-2 border">40"</td><td class="p-2 border">34"</td><td class="p-2 border">42"</td><td class="p-2 border">43"</td></tr>
                        <tr><td class="p-2 border font-bold">XL</td><td class="p-2 border">42"</td><td class="p-2 border">36"</td><td class="p-2 border">44"</td><td class="p-2 border">44"</td></tr>
                        <tr><td class="p-2 border font-bold">XXL</td><td class="p-2 border">44"</td><td class="p-2 border">38"</td><td class="p-2 border">46"</td><td class="p-2 border">44"</td></tr>
                    </tbody>
                </table>
            </div>
            <p class="text-[11px] text-stone-500 italic">For custom stitched suits, our master tailor will reach out to you via WhatsApp to note exact measurements.</p>
        </div>
    </div>

    <!-- Write Review Modal -->
    <div x-show="reviewModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
        <div @click.away="reviewModalOpen = false" class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl">
            <div class="flex items-center justify-between border-b pb-3">
                <h3 class="font-serif text-lg font-bold text-brand-charcoal">Write a Review</h3>
                <button type="button" @click="reviewModalOpen = false" class="text-stone-400 hover:text-stone-700">✕</button>
            </div>
            <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div>
                    <label class="block font-bold text-stone-700 mb-1">Star Rating (1 to 5) *</label>
                    <select name="rating" required class="w-full border rounded px-3 py-2">
                        <option value="5">★★★★★ (5 - Outstanding)</option>
                        <option value="4">★★★★☆ (4 - Very Good)</option>
                        <option value="3">★★★☆☆ (3 - Average)</option>
                        <option value="2">★★☆☆☆ (2 - Below Expectations)</option>
                        <option value="1">★☆☆☆☆ (1 - Poor)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-stone-700 mb-1">Your Name *</label>
                    <input type="text" name="author_name" value="{{ auth()->user()->name ?? '' }}" required class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block font-bold text-stone-700 mb-1">Your Email *</label>
                    <input type="email" name="author_email" value="{{ auth()->user()->email ?? '' }}" required class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block font-bold text-stone-700 mb-1">Review Headline</label>
                    <input type="text" name="title" placeholder="e.g. Royal embroidery, perfect fit!" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block font-bold text-stone-700 mb-1">Review Comments *</label>
                    <textarea name="comment" rows="4" required placeholder="Tell us about the fabric quality, stitching, and packaging..." class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <button type="submit" class="w-full py-3 bg-brand-maroon hover:bg-[#400c13] text-white font-bold uppercase tracking-wider rounded transition">
                    Submit Review
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
