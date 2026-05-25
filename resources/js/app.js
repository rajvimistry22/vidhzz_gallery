import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('siteLayout', () => ({
    mobileMenuOpen: false,
    copyBilling: true,
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
