<div
    x-data="recentPurchasesComponent()"
    x-show="show"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 translate-y-8 scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
    x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
    class="fixed bottom-6 left-6 z-40 max-w-sm rounded-2xl border border-stone-200 bg-white/95 p-4 shadow-luxury backdrop-blur-md flex items-center gap-3.5"
    style="display: none;"
>
    <div class="h-12 w-12 rounded-xl bg-amber-50 flex items-center justify-center border border-amber-100 text-amber-700 font-serif text-lg font-bold">
        🛍️
    </div>
    <div class="flex-1">
        <p class="text-xs text-stone-500 font-semibold uppercase tracking-wider">Recent Purchase</p>
        <p class="text-sm font-semibold text-stone-900 leading-snug mt-0.5">
            <span x-text="currentPurchase.customer"></span> from <span class="text-amber-800" x-text="currentPurchase.city"></span> bought <span class="italic text-stone-950 font-medium" x-text="currentPurchase.product"></span>.
        </p>
        <p class="text-[10px] text-stone-400 mt-1" x-text="currentPurchase.time"></p>
    </div>
</div>

<script>
function recentPurchasesComponent() {
    return {
        show: false,
        purchases: [
            { customer: 'Riya Patel', city: 'Ahmedabad', product: 'Gota Bead Navratri Set', time: '2 minutes ago' },
            { customer: 'Priya Shah', city: 'Surat', product: 'Silk Thread Bangles', time: '5 minutes ago' },
            { customer: 'Meera Doshi', city: 'Vadodara', product: 'Handmade Haldi Pooja Thali', time: '12 minutes ago' },
            { customer: 'Kashvi Vyas', city: 'Rajkot', product: 'Resin Flower Keychain', time: '20 minutes ago' }
        ],
        currentIndex: 0,
        currentPurchase: {},

        init() {
            this.currentPurchase = this.purchases[0];
            // Start the sequence after 15 seconds
            setTimeout(() => this.triggerNext(), 15000);
        },

        triggerNext() {
            this.currentPurchase = this.purchases[this.currentIndex];
            this.show = true;
            
            // Hide after 6 seconds
            setTimeout(() => {
                this.show = false;
                this.currentIndex = (this.currentIndex + 1) % this.purchases.length;
                
                // Trigger next purchase after 25 seconds
                setTimeout(() => this.triggerNext(), 25000);
            }, 6000);
        }
    };
}
</script>
