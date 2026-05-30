<div
    x-data="spinWheelComponent()"
    x-show="showPopup"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-stone-900/65 backdrop-blur-md"
    style="display: none;"
>
    <div class="relative w-full max-w-4xl overflow-hidden rounded-[2.5rem] border border-white/20 bg-white/90 p-6 shadow-2xl backdrop-blur-xl sm:p-10 lg:grid lg:grid-cols-2 lg:gap-10">
        {{-- Close button --}}
        <button
            @click="dismiss()"
            class="absolute right-6 top-6 z-10 flex h-10 w-10 items-center justify-center rounded-full border border-stone-200 bg-white text-stone-600 transition hover:bg-stone-50 hover:text-stone-950 focus:outline-none"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>

        {{-- Left side: Wheel graphics --}}
        <div class="relative flex items-center justify-center py-6">
            {{-- Decorative Outer golden ring glow --}}
            <div class="absolute inset-0 -z-10 rounded-full bg-amber-500/10 blur-2xl"></div>

            {{-- Pointer arrow --}}
            <div class="absolute top-0 z-20 -mt-2">
                <svg class="h-10 w-8 text-amber-600 drop-shadow-md" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 24l-8-12h16l-8 12z"/>
                </svg>
            </div>

            {{-- SVG Spinning Wheel --}}
            <div class="relative w-72 h-72 sm:w-80 sm:h-80 transition-transform ease-out duration-[4000ms]" :style="wheelStyle">
                <svg class="w-full h-full drop-shadow-xl" viewBox="0 0 200 200">
                    <defs>
                        <radialGradient id="goldGlow" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" stop-color="#fdf9ee" />
                            <stop offset="100%" stop-color="#f5de9d" />
                        </radialGradient>
                        <linearGradient id="primaryGold" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#b97a16" />
                            <stop offset="100%" stop-color="#7b4716" />
                        </linearGradient>
                    </defs>
                    
                    {{-- Wheel base --}}
                    <circle cx="100" cy="100" r="98" fill="#1c1917" stroke="#b97a16" stroke-width="3" />
                    
                    {{-- Segments (6 options - 60 degrees each) --}}
                    <!-- Seg 0: 5% OFF (Dark Amber) -->
                    <path d="M100,100 L100,6 A94,94 0 0,1 181.4,53 Z" fill="#881337" />
                    <!-- Seg 1: 15% OFF (Gold) -->
                    <path d="M100,100 L181.4,53 A94,94 0 0,1 181.4,147 Z" fill="#b97a16" />
                    <!-- Seg 2: Free Shipping (Charcoal) -->
                    <path d="M100,100 L181.4,147 A94,94 0 0,1 100,194 Z" fill="#1c1917" />
                    <!-- Seg 3: Try Again (Dark Amber) -->
                    <path d="M100,100 L100,194 A94,94 0 0,1 18.6,147 Z" fill="#881337" />
                    <!-- Seg 4: 10% OFF (Gold) -->
                    <path d="M100,100 L18.6,147 A94,94 0 0,1 18.6,53 Z" fill="#b97a16" />
                    <!-- Seg 5: 20% OFF (Charcoal) -->
                    <path d="M100,100 L18.6,53 A94,94 0 0,1 100,6 Z" fill="#1c1917" />

                    {{-- Inner divider lines --}}
                    <circle cx="100" cy="100" r="94" fill="none" stroke="#f5de9d" stroke-width="1.5" />
                    
                    {{-- Labels --}}
                    <g font-size="7" font-weight="bold" text-anchor="middle" dominant-baseline="middle">

                        <!-- 20% OFF -->
                        <text transform="translate(100 100) rotate(330) translate(0 -62)"
                            fill="#fdf9ee">
                            20% OFF
                        </text>

                        <!-- 5% OFF -->
                        <text transform="translate(100 100) rotate(30) translate(0 -62)"
                            fill="#fdf9ee">
                            5% OFF
                        </text>

                        <!-- 15% OFF -->
                        <text transform="translate(100 100) rotate(90) translate(0 -62)"
                            fill="#fdf9ee">
                            15% OFF
                        </text>

                        <!-- FREE SHIP -->
                        <text transform="translate(100 100) rotate(150) translate(0 -62)"
                            fill="#fdf9ee">
                            FREE SHIP
                        </text>

                        <!-- TRY AGAIN -->
                        <text transform="translate(100 100) rotate(210) translate(0 -62)"
                            fill="#fdf9ee">
                            TRY AGAIN
                        </text>

                        <!-- 10% OFF -->
                        <text transform="translate(100 100) rotate(270) translate(0 -62)"
                            fill="#fdf9ee">
                            10% OFF
                        </text>

                    </g>
                    
                    {{-- Center Pin --}}
                    <circle cx="100" cy="100" r="20" fill="url(#goldGlow)" stroke="#b97a16" stroke-width="2" />
                    <circle cx="100" cy="100" r="6" fill="#1c1917" />
                </svg>
            </div>
        </div>

        {{-- Right side: Controls & Outcomes --}}
        <div class="flex flex-col justify-center text-center lg:text-left">
            <template x-if="state === 'intro'">
                <div>
                    <span cltisan serveass="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-amber-700">Festive Gift</span>
                    <h2 class="mt-4 text-3xl font-semibold leading-tight text-stone-950 sm:text-4xl">Spin & Win Up to 20% Off!</h2>
                    <p class="mt-4 text-sm leading-relaxed text-stone-600">Try your luck today! Unlock exclusive discount codes and free shipping for your Navratri or Bangles collection favorites.</p>
                    
                    <button
                        @click="spinWheel()"
                        :disabled="spinning"
                        class="pulse-gold-btn mt-8 w-full rounded-full bg-stone-950 px-8 py-3 text-sm font-semibold uppercase tracking-widest text-white transition duration-300 hover:bg-amber-700 focus:outline-none disabled:opacity-50"
                    >
                        <span x-text="spinning ? 'Spinning...' : 'Spin Now'"></span>
                    </button>
                    <button @click="dismiss()" class="mt-4 text-xs font-semibold uppercase tracking-wider text-stone-400 hover:text-stone-700 transition">No thanks, I will pay full price</button>
                </div>
            </template>

            <template x-if="state === 'spinning'">
                <div class="space-y-4">
                    <div class="h-2 w-full overflow-hidden rounded-full bg-stone-100">
                        <div class="h-full bg-amber-500 transition-all duration-[4000ms]" style="width: 100%;"></div>
                    </div>
                    <h3 class="text-xl font-semibold text-stone-950">Selecting your festive reward...</h3>
                    <p class="text-sm text-stone-500">Wait as the traditional Gota wheels decide your discount.</p>
                </div>
            </template>

            <template x-if="state === 'won'">
                <div class="animate-zoom-in">
                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-700 text-center mx-auto lg:mx-0">Congratulations!</span>
                    <h2 class="mt-4 text-3xl font-semibold leading-tight text-stone-950 sm:text-4xl" x-text="rewardLabel"></h2>
                    <p class="mt-4 text-sm text-stone-600">Use your exclusive coupon code below at checkout to unlock savings. Valid for 48 hours.</p>

                    <div class="mt-6 flex flex-col items-center justify-between gap-3 rounded-2xl border border-dashed border-amber-300 bg-amber-50/50 p-4 sm:flex-row">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wider text-stone-400">Your Coupon Code</p>
                            <p class="text-xl font-bold tracking-widest text-amber-800" x-text="couponCode"></p>
                        </div>
                        <button
                            @click="copyCoupon()"
                            class="rounded-full bg-stone-950 px-5 py-2.5 text-xs font-semibold text-white hover:bg-amber-700 transition"
                        >
                            <span x-text="copied ? 'Copied!' : 'Copy Code'"></span>
                        </button>
                    </div>

                    <button
                        @click="dismiss()"
                        class="mt-6 w-full rounded-full bg-amber-700 px-8 py-3 text-sm font-semibold uppercase tracking-widest text-white transition hover:bg-stone-950"
                    >
                        Shop Now with Discount
                    </button>
                </div>
            </template>

            <template x-if="state === 'lost'">
                <div class="animate-zoom-in">
                    <span class="inline-flex rounded-full bg-stone-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-stone-600">Aww, Try Again!</span>
                    <h2 class="mt-4 text-3xl font-semibold leading-tight text-stone-950 sm:text-4xl">Try Again Next Time!</h2>
                    <p class="mt-4 text-sm text-stone-600">Better luck tomorrow. You can still browse our handcrafted Navratri styling designs and luxury bangle selections.</p>
                    
                    <button
                        @click="dismiss()"
                        class="mt-8 w-full rounded-full bg-stone-950 px-8 py-3 text-sm font-semibold uppercase tracking-widest text-white transition hover:bg-amber-700"
                    >
                        Continue Shopping
                    </button>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
function spinWheelComponent() {
    return {
        showPopup: false,
        spinning: false,
        state: 'intro', // intro, spinning, won, lost
        wheelRotation: 0,
        rewardLabel: '',
        couponCode: '',
        copied: false,

        get wheelStyle() {
            return `transform: rotate(${this.wheelRotation}deg);`;
        },

        init() {
            const justLoggedIn = {{ session('just_logged_in') ? 'true' : 'false' }};
            
            if (justLoggedIn) {
                // If just logged in, bypass client-side flags to guarantee immediate trigger
                localStorage.removeItem('spin_wheel_dismissed');
                localStorage.removeItem('spin_wheel_completed');

                this.checkEligibilityAndShow(true); // immediate
            } else {
                // Wait 10 seconds before triggering the popup if not spun or dismissed
                const alreadySpun = localStorage.getItem('spin_wheel_completed');
                const dismissed = localStorage.getItem('spin_wheel_dismissed');

                if (!alreadySpun && !dismissed) {
                    setTimeout(() => {
                        this.checkEligibilityAndShow(false);
                    }, 10000); // 10 seconds delay
                }
            }
        },

        async checkEligibilityAndShow(immediate) {
            try {
                const response = await fetch('/spin/check');
                const data = await response.json();
                if (!data.already_spun) {
                    this.showPopup = true;
                }
            } catch (e) {
                console.error('Check spin failed', e);
            }
        },

        async spinWheel() {
            if (this.spinning) return;
            this.spinning = true;
            this.state = 'spinning';

            try {
                const response = await fetch('/spin', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (!response.ok) {
                    throw new Error('Spin failed');
                }

                const data = await response.json();
                
                // Segments index logic (0-5, clockwise from top)
                // segment_index determines our ending angle
                // Centroid angles:
                // index 0 (5% OFF) -> center is 30 deg
                // index 1 (15% OFF) -> center is 90 deg
                // index 2 (Free Ship) -> center is 150 deg
                // index 3 (Try Again) -> center is 210 deg
                // index 4 (10% OFF) -> center is 270 deg
                // index 5 (20% OFF) -> center is 330 deg
                
                const segmentIndex = data.segment_index;
                const centerAngle = (segmentIndex * 60) + 30;
                
                // Spin 10 full rounds + offset to align won segment at the top pointer (0 deg)
                // To bring a segment with angle X clockwise from top to the top needle, we rotate by 360 - X.
                const targetRotation = (360 * 10) + (360 - centerAngle);
                
                this.wheelRotation = targetRotation;

                // Wait 4.2 seconds for rotation to complete
                setTimeout(() => {
                    this.spinning = false;
                    
                    if (data.reward === 'Try Again') {
                        this.state = 'lost';
                    } else {
                        this.state = 'won';
                        this.rewardLabel = data.reward;
                        this.couponCode = data.coupon_code;
                        
                        // Fire Confetti!
                        if (window.confetti) {
                            window.confetti({
                                particleCount: 150,
                                spread: 80,
                                origin: { y: 0.6 }
                            });
                        }
                    }
                    localStorage.setItem('spin_wheel_completed', 'true');
                }, 4200);

            } catch (err) {
                console.error(err);
                this.spinning = false;
                this.state = 'intro';
            }
        },

        copyCoupon() {
            navigator.clipboard.writeText(this.couponCode).then(() => {
                this.copied = true;
                setTimeout(() => this.copied = false, 2500);
            });
        },

        dismiss() {
            this.showPopup = false;
            localStorage.setItem('spin_wheel_dismissed', 'true');
        }
    };
}
</script>
