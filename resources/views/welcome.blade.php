<x-layouts.app>
    {{-- Hero Section — Warm Editorial Style, No Images --}}
    <section class="hero-editorial relative overflow-hidden">

        {{-- Background geometric blobs --}}
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <div class="hero-blob hero-blob-3"></div>

        {{-- Decorative dot grid --}}
        <div class="hero-dots"></div>

        {{-- Oversized background word --}}
        <span class="hero-bg-word" aria-hidden="true">VIDHZZ</span>

        {{-- Decorative SVG rings --}}
        <svg class="hero-ring hero-ring-1" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="100" cy="100" r="96" stroke="currentColor" stroke-width="1.5" stroke-dasharray="6 6"/>
        </svg>
        <svg class="hero-ring hero-ring-2" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="100" cy="100" r="96" stroke="currentColor" stroke-width="1" stroke-dasharray="3 8"/>
        </svg>

        {{-- Main content --}}
        <div class="container-shell relative z-10 py-28 lg:py-36">
            <div class="max-w-4xl mx-auto text-center space-y-8">


                {{-- Headline --}}
                <h1 class="hero-headline">
                    <span class="hero-headline-top">Handmade with</span>
                    <span class="hero-headline-accent">Love &amp; Heritage</span>
                    <span class="hero-headline-sub">for every celebration.</span>
                </h1>

                {{-- Description --}}
                <p class="hero-desc">
                    Exquisite Navratri styling, traditional Gujarati sets &amp; premium bangle collections —
                    crafted for the modern woman who honours her roots.
                </p>

                {{-- CTA Buttons --}}
                <div class="hero-actions">
                    <a href="{{ route('shop.products') }}" class="hero-cta-primary" id="hero-shop-btn">
                        Shop the Collection
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="{{ route('shop.categories') }}" class="hero-cta-secondary" id="hero-browse-btn">
                        Browse Collections
                    </a>
                </div>

                {{-- Stats strip --}}
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="hero-stat-num">500+</span>
                        <span class="hero-stat-label">Handmade Pieces</span>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="hero-stat">
                        <span class="hero-stat-num">1200+</span>
                        <span class="hero-stat-label">Happy Customers</span>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="hero-stat">
                        <span class="hero-stat-num">4.9 ★</span>
                        <span class="hero-stat-label">Avg. Rating</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Marquee ticker --}}
        <div class="hero-ticker" aria-hidden="true">
            <div class="hero-ticker-track">
                @foreach (range(1,6) as $_)
                    <span>Navratri Styling</span><span class="hero-ticker-dot">✦</span>
                    <span>Traditional Gujarati Sets</span><span class="hero-ticker-dot">✦</span>
                    <span>Premium Bangles</span><span class="hero-ticker-dot">✦</span>
                    <span>Handcrafted with Love</span><span class="hero-ticker-dot">✦</span>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        /* ── Hero Editorial ─────────────────────────────── */
        .hero-editorial {
            background: linear-gradient(135deg, #fdf6ee 0%, #fdecd8 35%, #fce4da 65%, #f9d5e5 100%);
            min-height: 92vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* blobs */
        .hero-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
        .hero-blob-1 { width: 480px; height: 480px; background: radial-gradient(circle, #f59e0b33, transparent 70%); top: -120px; left: -100px; animation: blobFloat 9s ease-in-out infinite alternate; }
        .hero-blob-2 { width: 380px; height: 380px; background: radial-gradient(circle, #f4717133, transparent 70%); bottom: 0; right: -80px; animation: blobFloat 12s ease-in-out infinite alternate-reverse; }
        .hero-blob-3 { width: 260px; height: 260px; background: radial-gradient(circle, #d97706 22, transparent 70%); top: 40%; left: 55%; animation: blobFloat 7s ease-in-out infinite alternate; }
        @keyframes blobFloat { 0% { transform: translate(0,0) scale(1); } 100% { transform: translate(30px,20px) scale(1.08); } }

        /* dot grid */
        .hero-dots {
            position: absolute; inset: 0; pointer-events: none; z-index: 0;
            background-image: radial-gradient(circle, #b4530044 1px, transparent 1px);
            background-size: 32px 32px;
            opacity: 0.35;
        }

        /* oversized bg word */
        .hero-bg-word {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            font-size: clamp(8rem, 22vw, 22rem);
            font-weight: 900;
            letter-spacing: -0.05em;
            color: transparent;
            -webkit-text-stroke: 1.5px #c2410c22;
            white-space: nowrap;
            pointer-events: none;
            user-select: none;
            z-index: 0;
            line-height: 1;
        }

        /* rings */
        .hero-ring {
            position: absolute;
            pointer-events: none;
            color: #c2410c;
            opacity: 0.12;
        }
        .hero-ring-1 { width: 420px; height: 420px; bottom: -100px; right: -80px; animation: spinRing 40s linear infinite; }
        .hero-ring-2 { width: 240px; height: 240px; top: 40px; left: -60px; animation: spinRing 28s linear infinite reverse; }
        @keyframes spinRing { to { transform: rotate(360deg); } }

        /* badge */
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: #fff8f0;
            border: 1px solid #f59e0b55;
            border-radius: 999px;
            padding: 6px 18px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #92400e;
            box-shadow: 0 2px 12px #f59e0b22;
        }
        .hero-badge-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #f59e0b;
            box-shadow: 0 0 0 3px #f59e0b33;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse { 0%,100% { box-shadow: 0 0 0 3px #f59e0b33; } 50% { box-shadow: 0 0 0 7px #f59e0b11; } }

        /* headline */
        .hero-headline {
            display: flex; flex-direction: column;
            gap: 0.1em;
            line-height: 1.05;
        }
        .hero-headline-top {
            font-size: clamp(2rem, 5vw, 3.75rem);
            font-weight: 400;
            color: #44403c;
            font-family: 'Georgia', serif;
            letter-spacing: -0.02em;
        }
        .hero-headline-accent {
            font-size: clamp(2.6rem, 7vw, 5.5rem);
            font-weight: 800;
            background: linear-gradient(120deg, #b45309 0%, #d97706 40%, #f59e0b 70%, #ef4444 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-family: 'Georgia', serif;
            letter-spacing: -0.03em;
        }
        .hero-headline-sub {
            font-size: clamp(1.1rem, 2.5vw, 1.75rem);
            font-weight: 400;
            color: #78716c;
            font-style: italic;
            font-family: 'Georgia', serif;
        }

        /* description */
        .hero-desc {
            font-size: clamp(0.875rem, 1.5vw, 1.05rem);
            color: #57534e;
            max-width: 560px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* CTA */
        .hero-actions { display: flex; flex-wrap: wrap; gap: 14px; justify-content: center; }
        .hero-cta-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #b45309, #d97706);
            color: #fff;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 14px 32px;
            border-radius: 999px;
            letter-spacing: 0.03em;
            text-decoration: none;
            box-shadow: 0 8px 28px #d9770655, 0 2px 8px #0001;
            transition: transform 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .hero-cta-primary:hover { transform: translateY(-2px); box-shadow: 0 14px 36px #d9770688; background: linear-gradient(135deg, #92400e, #b45309); }
        .hero-cta-primary svg { transition: transform 0.2s; }
        .hero-cta-primary:hover svg { transform: translateX(3px); }

        .hero-cta-secondary {
            display: inline-flex; align-items: center;
            border: 1.5px solid #a8a29e;
            color: #44403c;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 14px 32px;
            border-radius: 999px;
            text-decoration: none;
            background: #fff9;
            backdrop-filter: blur(4px);
            transition: border-color 0.2s, background 0.2s, color 0.2s, transform 0.2s;
        }
        .hero-cta-secondary:hover { border-color: #b45309; color: #b45309; background: #fff3e0; transform: translateY(-2px); }

        /* stats */
        .hero-stats {
            display: flex; align-items: center; justify-content: center;
            gap: 28px; flex-wrap: wrap;
            margin-top: 8px;
            padding-top: 24px;
            border-top: 1px solid #e7d5c055;
        }
        .hero-stat { display: flex; flex-direction: column; align-items: center; gap: 2px; }
        .hero-stat-num { font-size: 1.4rem; font-weight: 800; color: #92400e; line-height: 1; }
        .hero-stat-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.12em; color: #a8a29e; }
        .hero-stat-divider { width: 1px; height: 36px; background: #e7d5c0; }

        /* ticker */
        .hero-ticker {
            overflow: hidden;
            background: linear-gradient(90deg, #92400e, #b45309);
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 11px 0;
        }
        .hero-ticker-track {
            display: flex; gap: 32px; white-space: nowrap;
            animation: ticker 28s linear infinite;
            will-change: transform;
        }
        .hero-ticker-track span { flex-shrink: 0; }
        .hero-ticker-dot { color: #fcd34d; font-size: 0.6rem; }
        @keyframes ticker { from { transform: translateX(0); } to { transform: translateX(-50%); } }
    </style>

    {{-- Shop by Category --}}
    <section class="container-shell mt-24">
        <div class="text-center space-y-2">
            <p class="section-kicker">Curated Collections</p>
            <h2 class="section-title">Shop by Category</h2>
        </div>
        <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            @foreach ($categories as $category)
                <a href="{{ route('shop.category', $category) }}" class="group panel overflow-hidden p-4 hover-lift" x-data="imageCarousel(@js($category->gallery_urls), 2500)">
                    <div class="relative h-48 overflow-hidden rounded-[1.25rem] bg-stone-100">
                        <template x-for="(image, index) in images" :key="index">
                            <img
                                :src="image"
                                alt="{{ $category->name }}"
                                class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                x-show="activeIndex === index"
                                x-transition:enter="transition ease-out duration-700"
                                x-transition:enter-start="opacity-0 scale-105"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-500"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                            >
                        </template>
                    </div>
                    <div class="pt-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-stone-950 group-hover:text-amber-700 transition">{{ $category->name }}</h3>
                            <p class="text-xs text-stone-500 mt-1">{{ $category->products_count }} products</p>
                        </div>
                        <div class="h-8 w-8 rounded-full bg-stone-100 flex items-center justify-center text-stone-700 group-hover:bg-amber-600 group-hover:text-white transition">
                            →
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Bestsellers Highlight & Festive Pick banner --}}
    <section class="container-shell mt-24">
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2 relative overflow-hidden rounded-[2.5rem] border border-amber-200/50 bg-gradient-to-r from-amber-50 to-rose-50 p-8 sm:p-12 flex flex-col justify-between">
                <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-amber-200/40 blur-2xl"></div>
                <div class="space-y-4 max-w-lg z-10">
                    <span class="text-xs uppercase tracking-widest text-amber-700 font-bold">Limted Edition Pick</span>
                    <h2 class="text-3xl font-semibold text-stone-950 font-serif leading-tight sm:text-4xl">Gujarati Traditional Wear & Bangles Sets</h2>
                    <p class="text-sm leading-relaxed text-stone-600">Bring traditional Gujarati color and elegant design to your celebrations. Get free shipping on orders above Rs. 1,999 today!</p>
                </div>
                <div class="pt-8 z-10">
                    <a href="{{ route('shop.products') }}" class="btn-primary bg-stone-950 text-white font-semibold rounded-full px-6 py-3">Shop Limited Picks</a>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-[2.5rem] bg-stone-950 text-white p-8 sm:p-10 flex flex-col justify-between">
                <div class="absolute -left-10 -bottom-10 h-36 w-36 rounded-full bg-amber-500/20 blur-2xl"></div>
                <div class="space-y-4 z-10">
                    <span class="text-xs uppercase tracking-widest text-amber-400 font-bold">Addictive Gaming</span>
                    <h2 class="text-3xl font-semibold font-serif leading-tight">Spin & Win Coupon!</h2>
                    <p class="text-xs text-stone-300">Wait 10 seconds on our website or try spinning our luck wheel to unlock discounts from 5% up to 20% off.</p>
                </div>
                <div class="pt-8 z-10">
                    <button @click="window.dispatchEvent(new CustomEvent('spin-wheel-trigger'))" class="btn-primary bg-amber-600 hover:bg-amber-700 text-white rounded-full px-6 py-2.5 text-xs font-semibold uppercase tracking-wider">Play Now</button>
                </div>
            </div>
        </div>
    </section>

    {{-- New Arrivals --}}
    <section class="container-shell mt-24">
        <div class="flex items-end justify-between gap-6 border-b border-stone-200 pb-5">
            <div>
                <p class="section-kicker">Fresh Releases</p>
                <h2 class="section-title">New Arrivals</h2>
            </div>
            <a href="{{ route('shop.products') }}" class="text-sm font-semibold text-amber-700 hover:underline">View all →</a>
        </div>
        <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($newArrivals as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

    {{-- Bestsellers --}}
    <section class="container-shell mt-24">
        <div class="flex items-end justify-between gap-6 border-b border-stone-200 pb-5">
            <div>
                <p class="section-kicker">Most Loved</p>
                <h2 class="section-title">Bestsellers</h2>
            </div>
            <a href="{{ route('shop.products') }}" class="text-sm font-semibold text-amber-700 hover:underline">View all →</a>
        </div>
        <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($trendingProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

    {{-- Instagram style Gallery --}}
    <section class="container-shell mt-24">
        <div class="text-center space-y-2">
            <p class="section-kicker">Social Proof</p>
            <h2 class="section-title">Share Your Festive Look</h2>
            <p class="muted-copy mx-auto max-w-lg">Tag <span class="font-bold text-amber-700">@vidhzz_.gallery</span> on Instagram to get featured in our customer gallery!</p>
        </div>
        <div class="mt-12 grid gap-4 grid-cols-2 md:grid-cols-4">
            @foreach ($galleryItems as $index => $item)
                <div class="group relative overflow-hidden rounded-3xl aspect-square border border-stone-150">
                    <img src="{{ $item['image'] }}" onerror="this.src='https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&q=80&w=400'" alt="{{ $item['title'] }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-stone-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 p-6 flex flex-col justify-end">
                        <span class="text-xs uppercase tracking-widest text-amber-400 font-bold">Instagram</span>
                        <h4 class="text-sm text-white font-semibold mt-1">{{ $item['title'] }}</h4>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Customer Reviews --}}
    <section class="container-shell mt-24">
        <div class="text-center space-y-2">
            <p class="section-kicker">Happy Customers</p>
            <h2 class="section-title">Kind Words From Our Patrons</h2>
        </div>
        <div class="mt-12 grid gap-8 md:grid-cols-3">
            @foreach ($testimonials as $testimonial)
                <div class="panel p-8 space-y-4 border border-stone-150 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex gap-1 text-amber-500">
                            {{-- 5 Star SVG --}}
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="italic text-stone-600 text-sm">"{{ $testimonial['quote'] }}"</p>
                    </div>
                    <div>
                        <h4 class="font-bold text-stone-900 text-sm">{{ $testimonial['name'] }}</h4>
                        <p class="text-xs text-amber-700 mt-0.5">{{ $testimonial['city'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</x-layouts.app>
