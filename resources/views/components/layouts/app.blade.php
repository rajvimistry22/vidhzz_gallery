<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Vidhzz Gallery | Handmade Collections' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Handmade Navratri, bangles, resin, haldi, and baby shower collections with a clean modern shopping experience.' }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-shell overflow-x-hidden" x-data="siteLayout">
    @php
        $navCategories = \App\Models\Category::active()->ordered()->take(5)->get();
        $cartRecord = \App\Models\Cart::query()
            ->when(
                auth()->check(),
                fn ($query) => $query->where('user_id', auth()->id()),
                fn ($query) => $query->where('session_id', session()->getId())
            )
            ->withSum('items', 'quantity')
            ->first();
        $cartCount = (int) ($cartRecord?->items_sum_quantity ?? 0);
    @endphp

    <div class="border-b border-stone-200 bg-stone-950 text-[11px] uppercase tracking-[0.28em] text-stone-200">
        <div class="container-shell flex flex-wrap items-center justify-center gap-3 py-3 text-center">
            <span>Handmade festive collections</span>
            <span class="hidden h-1 w-1 rounded-full bg-amber-600 sm:block"></span>
            <span>Free shipping above Rs. 1,999</span>
        </div>
    </div>

    <header class="sticky top-0 z-40 border-b border-stone-200/80 bg-white/90 backdrop-blur-xl">
        <div class="container-shell flex items-center justify-between py-4">
            <a href="{{ route('shop.home') }}" class="flex flex-col">
                <span class="text-xl font-semibold tracking-[0.24em] text-stone-950 sm:text-2xl">VIDHZZ GALLERY</span>
                <span class="text-[10px] uppercase tracking-[0.28em] text-stone-500">Handmade collections</span>
            </a>

            <nav class="hidden items-center gap-8 lg:flex">
                <a href="{{ route('shop.home') }}" class="nav-link {{ request()->routeIs('shop.home') ? 'nav-link-active' : '' }}">Home</a>
                <a href="{{ route('shop.categories') }}" class="nav-link {{ request()->routeIs('shop.categories', 'shop.category') ? 'nav-link-active' : '' }}">Collections</a>
                <a href="{{ route('shop.products') }}" class="nav-link {{ request()->routeIs('shop.products', 'shop.product') ? 'nav-link-active' : '' }}">Shop All</a>
                <a href="{{ route('shop.about') }}" class="nav-link {{ request()->routeIs('shop.about') ? 'nav-link-active' : '' }}">About</a>
                <a href="{{ route('shop.contact') }}" class="nav-link {{ request()->routeIs('shop.contact') ? 'nav-link-active' : '' }}">Contact</a>
            </nav>

            <div class="hidden items-center gap-4 lg:flex">
                <form action="{{ route('shop.search') }}" method="GET" class="relative">
                    <input name="q" value="{{ request('q') }}" placeholder="Search styles" class="w-52 rounded-full border border-stone-200 bg-stone-50 py-2 pl-4 pr-10 text-sm">
                    <button class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400" aria-label="Search">Search</button>
                </form>
                @auth
                    <a href="{{ route('wishlist.index') }}" class="nav-link flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-stone-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        <span>Wishlist</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-link flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-stone-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        <span>Wishlist</span>
                    </a>
                @endauth
                <button @click.prevent="cartOpen = true" class="nav-link flex items-center gap-1.5 focus:outline-none">
                    <svg class="h-4 w-4 text-stone-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    <span>Cart (<span id="cart-counter-display">{{ $cartCount }}</span>)</span>
                </button>
                @auth
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center gap-1 nav-link focus:outline-none">
                            <span>Account</span>
                            <svg class="h-3.5 w-3.5 transition duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute right-0 mt-2 w-48 rounded-2xl border border-stone-200 bg-white py-2 shadow-luxury z-50">
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('account.dashboard') }}" class="block px-4 py-2 text-sm text-stone-700 hover:bg-stone-50">Dashboard</a>
                            <form action="{{ route('logout') }}" method="POST" class="block w-full">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-stone-600 hover:bg-stone-50 hover:text-rose-600 font-medium">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                @endauth
            </div>
 
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="rounded-full border border-stone-200 p-2 lg:hidden">
                <span class="block h-0.5 w-5 bg-stone-900"></span>
                <span class="mt-1 block h-0.5 w-5 bg-stone-900"></span>
                <span class="mt-1 block h-0.5 w-5 bg-stone-900"></span>
            </button>
        </div>
 
        <div x-show="mobileMenuOpen" x-transition class="border-t border-stone-200 bg-white lg:hidden">
            <div class="container-shell space-y-4 py-4">
                <form action="{{ route('shop.search') }}" method="GET">
                    <input name="q" value="{{ request('q') }}" placeholder="Search styles" class="input">
                </form>
                <div class="grid gap-3 text-sm font-medium text-stone-700">
                    <a href="{{ route('shop.home') }}" class="{{ request()->routeIs('shop.home') ? 'text-amber-700 font-semibold' : '' }}">Home</a>
                    <a href="{{ route('shop.categories') }}" class="{{ request()->routeIs('shop.categories', 'shop.category') ? 'text-amber-700 font-semibold' : '' }}">Collections</a>
                    <a href="{{ route('shop.products') }}" class="{{ request()->routeIs('shop.products', 'shop.product') ? 'text-amber-700 font-semibold' : '' }}">Shop All</a>
                    <a href="#" @click.prevent="cartOpen = true; mobileMenuOpen = false">Cart (<span id="cart-counter-display-mobile">{{ $cartCount }}</span>)</a>
                    <a href="{{ route('shop.about') }}" class="{{ request()->routeIs('shop.about') ? 'text-amber-700 font-semibold' : '' }}">About</a>
                    <a href="{{ route('shop.contact') }}" class="{{ request()->routeIs('shop.contact') ? 'text-amber-700 font-semibold' : '' }}">Contact</a>
                    @auth
                        <div class="h-px bg-stone-200 my-1"></div>
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('account.dashboard') }}" class="text-amber-800">My Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline-block w-full">
                            @csrf
                            <button type="submit" class="text-left text-rose-600 font-semibold w-full">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-amber-800">Login / Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>
 
    <main class="min-h-screen relative">
        {{-- Subtle ambient blur shapes to give visual depth --}}
        <div class="pointer-events-none absolute left-[-10%] top-[5%] -z-10 h-[30rem] w-[30rem] rounded-full bg-amber-100/35 blur-[120px]"></div>
        <div class="pointer-events-none absolute right-[-5%] top-[25%] -z-10 h-[35rem] w-[35rem] rounded-full bg-stone-200/40 blur-[130px]"></div>
        <div class="pointer-events-none absolute left-[15%] bottom-[15%] -z-10 h-[28rem] w-[28rem] rounded-full bg-amber-50/45 blur-[110px]"></div>
 
        <x-flash />
        {{ $slot }}
    </main>
 
    <footer class="mt-20 border-t border-stone-200 bg-white">
        <div class="container-shell grid gap-10 py-16 lg:grid-cols-[1.2fr,1fr,1fr,1fr]">
            <div>
                <p class="section-kicker">Vidhzz Gallery</p>
                <h3 class="mt-3 text-xl font-semibold text-stone-950 sm:text-2xl">Handmade collections for celebrations, gifting, and modern Indian styling.</h3>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-stone-500">Collections</p>
                <div class="mt-4 space-y-3 text-sm text-stone-600">
                    @foreach ($navCategories as $category)
                        <a href="{{ route('shop.category', $category) }}" class="block hover:text-amber-700">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-stone-500">Customer</p>
                <div class="mt-4 space-y-3 text-sm text-stone-600">
                    <a href="{{ route('shop.about') }}" class="block hover:text-amber-700">About us</a>
                    <a href="{{ route('shop.contact') }}" class="block hover:text-amber-700">Contact</a>
                    @auth
                        <a href="{{ route('account.orders') }}" class="block hover:text-amber-700">Order tracking</a>
                    @endauth
                </div>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-stone-500">Newsletter</p>
                <form class="mt-4 space-y-3">
                    <input class="input" placeholder="Your email address">
                    <button type="button" class="btn-primary w-full">Join Newsletter</button>
                </form>
            </div>
        </div>
    </footer>

    {{-- Floating WhatsApp button --}}
    <div class="fixed bottom-6 right-6 z-40 transition-all duration-300 hover:scale-110">
        <a href="https://wa.me/919664716788?text=Hi%20Vidhzz%20Gallery,%20I%20have%20an%20inquiry%20about%20your%20beautiful%20handcrafted%20collections!" target="_blank" class="flex h-14 w-14 items-center justify-center rounded-full bg-emerald-500 text-white shadow-luxury hover:bg-emerald-600">
            <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.625 1.451 5.403.002 9.792-4.382 9.795-9.786.002-2.617-1.015-5.078-2.862-6.93C16.357 2.036 13.906 1.017 12 1.017c-5.41 0-9.802 4.39-9.805 9.795-.001 1.57.424 3.103 1.233 4.473L2.345 20.8l5.522-1.449c-1.393-.847-2.222-2.062-2.222-3.565 0-3.328 2.709-6.037 6.037-6.037s6.037 2.709 6.037 6.037-2.709 6.037-6.037 6.037c-1.312 0-2.529-.425-3.535-1.15z"/>
            </svg>
        </a>
    </div>

    {{-- Recent Purchase Toast and Spin the Wheel Components --}}
    <x-spin-wheel />
    <x-cart-drawer />

    <x-recent-purchases />

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
</body>
</html>
