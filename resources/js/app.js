import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Dynamic Base URL Resolver (supports subfolders like /Gauri suits & Jewel/public)
window.apiUrl = window.apiUrl || function(path) {
    if (!path) return ((window.AppConfig && window.AppConfig.baseUrl) || '').replace(/&amp;/g, '&');
    const clean = path.replace(/&amp;/g, '&');
    if (clean.startsWith('http://') || clean.startsWith('https://')) return clean;
    let base = (window.AppConfig && window.AppConfig.baseUrl) ? window.AppConfig.baseUrl.replace(/\/+$/, '') : '';
    base = base.replace(/&amp;/g, '&');
    const cleanPath = clean.replace(/^\/+/, '');
    return base ? `${base}/${cleanPath}` : `/${cleanPath}`;
};

const getApiUrl = (path) => window.apiUrl(path);
const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || (window.AppConfig?.csrfToken || '');

// Global Toast Notifications
window.showToast = function(message, type = 'success') {
    window.dispatchEvent(new CustomEvent('toast-message', {
        detail: { message, type }
    }));
};

// Cart Drawer Store / Alpine Component
Alpine.data('cartDrawer', () => ({
    open: false,
    loading: false,
    summary: {
        items: [],
        total_items: 0,
        subtotal: 0,
        discount: 0,
        coupon_code: '',
        free_shipping_threshold: 2999,
        amount_needed_free_shipping: 2999,
        free_shipping_percent: 0,
        free_shipping_unlocked: false,
    },

    init() {
        this.fetchSummary();
        window.addEventListener('open-cart', () => {
            this.open = true;
            this.fetchSummary();
        });
        window.addEventListener('cart-updated', () => {
            this.fetchSummary();
        });
    },

    async fetchSummary() {
        try {
            const res = await fetch(getApiUrl('/cart/summary'), { credentials: 'same-origin' });
            if (res.ok) {
                this.summary = await res.json();
                // Update badge in header
                const badge = document.getElementById('header-cart-badge');
                if (badge) {
                    badge.innerText = this.summary.total_items;
                    badge.style.display = this.summary.total_items > 0 ? 'flex' : 'none';
                }
            }
        } catch (e) {
            console.error('Failed to fetch cart summary', e);
        }
    },

    async updateQty(itemId, newQty) {
        this.loading = true;
        try {
            const res = await fetch(getApiUrl('/cart/update'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ item_id: itemId, quantity: newQty }),
            });
            const data = await res.json();
            if (res.ok && data.success) {
                this.summary = data.cart;
                window.showToast(data.message, 'success');
            } else {
                window.showToast(data.message || 'Failed to update item.', 'error');
            }
        } catch (e) {
            window.showToast('Failed to update cart.', 'error');
        } finally {
            this.loading = false;
        }
    },

    async removeItem(itemId) {
        this.loading = true;
        try {
            const res = await fetch(getApiUrl(`/cart/remove/${itemId}`), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                },
            });
            const data = await res.json();
            if (res.ok && data.success) {
                this.summary = data.cart;
                window.showToast(data.message, 'success');
            } else {
                window.showToast(data.message || 'Failed to remove item.', 'error');
            }
        } catch (e) {
            window.showToast('Failed to remove item.', 'error');
        } finally {
            this.loading = false;
        }
    }
}));

// Quick View Modal Component
Alpine.data('quickViewModal', () => ({
    open: false,
    loading: false,
    product: null,
    selectedVariant: null,
    selectedSize: '',
    selectedColour: '',
    quantity: 1,

    async show(productId) {
        this.open = true;
        this.loading = true;
        this.product = null;
        try {
            const res = await fetch(getApiUrl(`/api/quick-view/${productId}`));
            if (res.ok) {
                this.product = await res.json();
                if (this.product.variants && this.product.variants.length > 0) {
                    this.selectedVariant = this.product.variants[0];
                    this.selectedSize = this.selectedVariant.size;
                    this.selectedColour = this.selectedVariant.colour;
                }
            }
        } catch (e) {
            window.showToast('Error loading quick view', 'error');
        } finally {
            this.loading = false;
        }
    },

    selectVariant(variant) {
        this.selectedVariant = variant;
        this.selectedSize = variant.size;
        this.selectedColour = variant.colour;
    },

    async addToCart() {
        if (!this.product) return;
        this.loading = true;

        try {
            const res = await fetch(getApiUrl('/cart/add'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: this.product.id,
                    variant_id: this.selectedVariant ? this.selectedVariant.id : null,
                    quantity: this.quantity,
                })
            });

            const data = await res.json();
            if (res.ok && data.success) {
                this.open = false;
                window.dispatchEvent(new CustomEvent('cart-updated'));
                window.dispatchEvent(new CustomEvent('open-cart'));
                window.showToast(data.message || 'Added to bag!', 'success');
            } else {
                window.showToast(data.message || 'Unable to add item.', 'error');
            }
        } catch (e) {
            window.showToast('Failed to add item to cart', 'error');
        } finally {
            this.loading = false;
        }
    }
}));

// Instant Search Modal Component
Alpine.data('searchModal', () => ({
    open: false,
    query: '',
    loading: false,
    results: { products: [], categories: [] },
    debounceTimer: null,

    onInput() {
        clearTimeout(this.debounceTimer);
        if (this.query.trim().length < 2) {
            this.results = { products: [], categories: [] };
            return;
        }

        this.loading = true;
        this.debounceTimer = setTimeout(async () => {
            try {
                const res = await fetch(getApiUrl(`/search/suggestions?q=${encodeURIComponent(this.query)}`));
                if (res.ok) {
                    this.results = await res.json();
                }
            } catch (e) {
                console.error(e);
            } finally {
                this.loading = false;
            }
        }, 300);
    }
}));

// Wishlist Toggle Function
window.toggleWishlist = async function(productId, btnElement) {
    try {
        const res = await fetch(getApiUrl('/wishlist/toggle'), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ product_id: productId })
        });

        if (res.status === 401) {
            window.location.href = getApiUrl('/login');
            return;
        }

        const data = await res.json();
        if (data.success) {
            window.showToast(data.message, 'success');

            // Update badge in header
            const badge = document.getElementById('header-wishlist-badge');
            if (badge) {
                badge.innerText = data.count;
                badge.style.display = data.count > 0 ? 'flex' : 'none';
            }

            // Update icon appearance
            if (btnElement) {
                const svg = btnElement.querySelector('svg');
                if (svg) {
                    if (data.in_wishlist) {
                        svg.setAttribute('fill', 'currentColor');
                        svg.classList.add('text-rose-600');
                    } else {
                        svg.setAttribute('fill', 'none');
                        svg.classList.remove('text-rose-600');
                    }
                }
            }
        } else {
            window.showToast(data.message || 'Unable to update wishlist.', 'error');
        }
    } catch (e) {
        window.showToast('Something went wrong.', 'error');
    }
};

// Direct Add to Cart Function for Product Cards
window.addToCartDirect = async function(productId, variantId = null, quantity = 1, btnElement = null) {
    let originalText = '';
    if (btnElement) {
        originalText = btnElement.innerText;
        btnElement.innerText = 'ADDING...';
        btnElement.disabled = true;
    }

    try {
        const res = await fetch(getApiUrl('/cart/add'), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                variant_id: variantId,
                quantity: quantity
            })
        });

        const contentType = res.headers.get('content-type') || '';
        let data = {};
        if (contentType.includes('application/json')) {
            data = await res.json();
        } else {
            const text = await res.text();
            console.error('Non-JSON server response:', text);
            throw new Error(`Server returned status ${res.status}`);
        }

        if (res.ok && data.success) {
            window.dispatchEvent(new CustomEvent('cart-updated'));
            window.dispatchEvent(new CustomEvent('open-cart'));
            window.showToast(data.message || 'Added to bag!', 'success');
        } else {
            window.showToast(data.message || 'Unable to add item to bag.', 'error');
        }
    } catch (e) {
        console.error('addToCartDirect error:', e);
        const msg = (e.message && !e.message.includes('Server returned')) ? e.message : 'Failed to add item to bag.';
        window.showToast(msg, 'error');
    } finally {
        if (btnElement) {
            btnElement.innerText = originalText;
            btnElement.disabled = false;
        }
    }
};

Alpine.start();

