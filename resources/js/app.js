import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('siteLayout', () => ({
    mobileMenuOpen: false,
    copyBilling: true,
    cartOpen: false,
    cartHtml: '',
    loadingCart: false,

    init() {
        // Intercept any Add to Cart form submission to handle it via AJAX
        document.addEventListener('submit', async (e) => {
            const form = e.target;
            const isCartPost = form.action && (form.action.endsWith('/cart') || form.action.includes('/cart?')) && form.method.toLowerCase() === 'post';
            
            // We only intercept if it's not a coupon form, or we can handle coupon too!
            if (isCartPost && !form.querySelector('input[name="code"]') && !form.querySelector('input[name="_method"][value="DELETE"]')) {
                e.preventDefault();
                this.loadingCart = true;
                this.cartOpen = true; // Open the drawer immediately to show activity
                
                try {
                    const formData = new FormData(form);
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    
                    if (response.ok) {
                        const data = await response.json();
                        this.cartHtml = data.html;
                        
                        // Update cart counter badges
                        const count = data.cart.items.reduce((sum, item) => sum + parseInt(item.quantity), 0);
                        const counterEl = document.getElementById('cart-counter-display');
                        const counterElMobile = document.getElementById('cart-counter-display-mobile');
                        if (counterEl) counterEl.textContent = count;
                        if (counterElMobile) counterElMobile.textContent = count;
                    }
                } catch (err) {
                    console.error('Error adding product to cart:', err);
                } finally {
                    this.loadingCart = false;
                }
            }
        });

        // Initialize cart drawer HTML
        this.refreshCartDrawer();
    },

    async refreshCartDrawer() {
        this.loadingCart = true;
        try {
            const response = await fetch('/cart', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            if (response.ok) {
                const data = await response.json();
                this.cartHtml = data.html;
            }
        } catch (err) {
            console.error('Error refreshing cart:', err);
        } finally {
            this.loadingCart = false;
        }
    },

    async updateQuantity(itemId, quantity) {
        if (quantity < 1) return;
        this.loadingCart = true;
        try {
            const response = await fetch(`/cart/items/${itemId}`, {
                method: 'POST',
                body: JSON.stringify({ _method: 'PATCH', quantity }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            if (response.ok) {
                const data = await response.json();
                this.cartHtml = data.html;
                
                const count = data.cart.items.reduce((sum, item) => sum + parseInt(item.quantity), 0);
                const counterEl = document.getElementById('cart-counter-display');
                const counterElMobile = document.getElementById('cart-counter-display-mobile');
                if (counterEl) counterEl.textContent = count;
                if (counterElMobile) counterElMobile.textContent = count;
            }
        } catch (err) {
            console.error('Error updating quantity:', err);
        } finally {
            this.loadingCart = false;
        }
    },

    async removeCartItem(itemId) {
        this.loadingCart = true;
        try {
            const response = await fetch(`/cart/items/${itemId}`, {
                method: 'POST',
                body: JSON.stringify({ _method: 'DELETE' }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            if (response.ok) {
                const data = await response.json();
                this.cartHtml = data.html;
                
                const count = data.cart.items.reduce((sum, item) => sum + parseInt(item.quantity), 0);
                const counterEl = document.getElementById('cart-counter-display');
                const counterElMobile = document.getElementById('cart-counter-display-mobile');
                if (counterEl) counterEl.textContent = count;
                if (counterElMobile) counterElMobile.textContent = count;
            }
        } catch (err) {
            console.error('Error removing item:', err);
        } finally {
            this.loadingCart = false;
        }
    },

    async applyCouponCode(code) {
        if (!code) return;
        this.loadingCart = true;
        try {
            const response = await fetch('/cart/coupon', {
                method: 'POST',
                body: JSON.stringify({ code }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            const data = await response.json();
            if (response.ok) {
                this.cartHtml = data.html;
            } else {
                alert(data.message || (data.errors && data.errors.coupon ? data.errors.coupon[0] : 'Failed to apply coupon'));
            }
        } catch (err) {
            console.error('Error applying coupon:', err);
        } finally {
            this.loadingCart = false;
        }
    },

    async removeCouponCode() {
        this.loadingCart = true;
        try {
            const response = await fetch('/cart/coupon', {
                method: 'POST',
                body: JSON.stringify({ _method: 'DELETE' }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            if (response.ok) {
                const data = await response.json();
                this.cartHtml = data.html;
            }
        } catch (err) {
            console.error('Error removing coupon:', err);
        } finally {
            this.loadingCart = false;
        }
    }
}));

Alpine.data('productDetail', (variants = []) => ({
    variants,
    selectedVariantId: variants[0]?.id ?? null,
    quantity: 1,
    get selectedVariant() {
        return this.variants.find((variant) => variant.id === this.selectedVariantId) ?? null;
    },
    increment() {
        this.quantity += 1;
    },
    decrement() {
        this.quantity = Math.max(1, this.quantity - 1);
    },
}));

Alpine.data('imageCarousel', (images = [], interval = 2000) => ({
    images,
    interval,
    activeIndex: 0,
    timer: null,

    setActive(index) {
        this.activeIndex = index;

        // Prevent autoplay from fighting with user selection.
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }

        // Optional: restart autoplay after a short delay.
        if (this.images.length > 1) {
            setTimeout(() => {
                if (this.timer || this.images.length <= 1) return;
                this.timer = setInterval(() => {
                    this.activeIndex = (this.activeIndex + 1) % this.images.length;
                }, this.interval);
            }, 2500);
        }
    },

    init() {
        if (!this.images.length || this.images.length <= 1) {
            return;
        }

        this.timer = setInterval(() => {
            this.activeIndex = (this.activeIndex + 1) % this.images.length;
        }, this.interval);
    },
}));

Alpine.data('productGallery', (images = []) => ({
    images,
    activeIndex: 0,
    zoomX: '50%',
    zoomY: '50%',
    isZoomed: false,

    setActive(index) {
        this.activeIndex = index;
    },

    handleMouseMove(e) {
        const rect = e.currentTarget.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        const y = ((e.clientY - rect.top) / rect.height) * 100;
        this.zoomX = `${x}%`;
        this.zoomY = `${y}%`;
        this.isZoomed = true;
    },

    handleMouseLeave() {
        this.isZoomed = false;
        this.zoomX = '50%';
        this.zoomY = '50%';
    }
}));

const setupRevealAnimations = () => {
    const revealItems = document.querySelectorAll('[data-reveal]');

    if (!revealItems.length) {
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
        });
    }, {
        threshold: 0.15,
        rootMargin: '0px 0px -60px 0px',
    });

    revealItems.forEach((item, index) => {
        item.style.setProperty('--reveal-delay', `${Math.min(index * 60, 240)}ms`);
        observer.observe(item);
    });
};

document.addEventListener('DOMContentLoaded', setupRevealAnimations);

Alpine.start();
