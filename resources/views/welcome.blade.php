<x-layouts.app>
    <section class="container-shell reveal pt-8 sm:pt-12" data-reveal>
        <div class="relative overflow-hidden rounded-[2rem] bg-stone-950 px-6 py-10 text-white sm:px-10 lg:px-12">
            <div class="hero-orb -left-8 top-0 h-40 w-40"></div>
            <div class="hero-orb bottom-0 right-8 h-52 w-52"></div>
            <div class="relative grid gap-8 lg:grid-cols-[1.1fr,0.9fr] lg:items-center">
                <div class="z-10">
                    <p class="badge-soft text-stone-900 font-semibold tracking-widest">Handmade with Love</p>
                    <h1 class="mt-5 max-w-3xl text-3xl font-semibold leading-tight sm:text-4xl lg:text-5xl">Handmade festive fashion with a softer, richer, more modern shopping feel.</h1>
                    <p class="mt-4 max-w-2xl text-sm leading-7 text-stone-300 sm:text-base">Shop curated Navratri, bangles, resin, haldi, and baby shower collections with premium styling, smoother browsing, and mobile-first clarity.</p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('shop.products') }}" class="btn-primary">Shop All Products</a>
                        <a href="{{ route('shop.categories') }}" class="btn-secondary border-white/25 bg-white/10 text-white hover:bg-white hover:text-stone-950">Browse Collections</a>
                    </div>
                </div>
                <div class="relative hidden lg:block">
                    <div class="relative mx-auto w-full max-w-[340px]">
                        {{-- Ambient backdrop glow --}}
                        <div class="absolute -inset-4 rounded-[2rem] bg-gradient-to-r from-amber-600 to-amber-700 opacity-40 blur-2xl"></div>
                        {{-- Front Image --}}
                        <div class="relative overflow-hidden rounded-[2rem] border border-white/10 shadow-2xl transition duration-500 hover:scale-[1.02]">
                            <img src="{{ asset('images/banners/navratri_banner.png') }}" alt="Navratri Collection" class="h-[400px] w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent p-6 flex flex-col justify-end">
                                <span class="text-xs uppercase tracking-widest text-amber-400 font-semibold">Festive Special</span>
                                <h3 class="text-lg font-semibold text-white mt-1">Gota & Bead Collections</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container-shell mt-20 reveal" data-reveal>
        <div class="flex items-end justify-between gap-6">
            <div>
                <p class="section-kicker">Featured Categories</p>
                <h2 class="section-title">Curated category sections</h2>
            </div>
        </div>
        <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-5">
            @foreach ($categories as $category)
                <a href="{{ route('shop.category', $category) }}" class="panel panel-float hover-lift p-6" x-data="imageCarousel(@js($category->gallery_urls), 2000)">
                    <div class="relative h-24 overflow-hidden rounded-[1.5rem]">
                        <template x-for="(image, index) in images" :key="index">
                            <img
                                :src="image"
                                alt="{{ $category->name }}"
                                class="absolute inset-0 h-full w-full object-cover"
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
                    <h3 class="mt-5 text-xl font-semibold text-stone-950">{{ $category->name }}</h3>
                    <p class="mt-2 text-sm text-stone-500">{{ $category->products_count }} products</p>
                </a>
            @endforeach
        </div>
    </section>

    <section class="container-shell mt-16 reveal" data-reveal>
        <div class="flex items-end justify-between gap-6">
            <div>
            <p class="section-kicker">New Arrivals</p>
            <h2 class="section-title">Freshly added new arrivals</h2>
            </div>
            <a href="{{ route('shop.products') }}" class="text-sm font-semibold text-amber-700">View all</a>
        </div>
        <div class="mt-10 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($newArrivals as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

</x-layouts.app>
