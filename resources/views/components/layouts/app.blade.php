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
                <a href="{{ route('shop.home') }}" class="nav-link">Home</a>
                <a href="{{ route('shop.categories') }}" class="nav-link">Collections</a>
                <a href="{{ route('shop.products') }}" class="nav-link">Shop All</a>
                <a href="{{ route('shop.about') }}" class="nav-link">About</a>
                <a href="{{ route('shop.contact') }}" class="nav-link">Contact</a>
            </nav>

            <div class="hidden items-center gap-4 lg:flex">
                <form action="{{ route('shop.search') }}" method="GET" class="relative">
                    <input name="q" value="{{ request('q') }}" placeholder="Search styles" class="w-52 rounded-full border border-stone-200 bg-stone-50 py-2 pl-4 pr-10 text-sm">
                    <button class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400" aria-label="Search">Search</button>
                </form>
                @auth
                    <a href="{{ route('wishlist.index') }}" class="nav-link">Wishlist</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Wishlist</a>
                @endauth
                <a href="{{ route('cart.index') }}" class="nav-link">Cart ({{ $cartCount }})</a>
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('account.dashboard') }}" class="nav-link">Account</a>
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
                    <a href="{{ route('shop.home') }}">Home</a>
                    <a href="{{ route('shop.categories') }}">Collections</a>
                    <a href="{{ route('shop.products') }}">Shop All</a>
                    <a href="{{ route('cart.index') }}">Cart</a>
                    <a href="{{ route('shop.about') }}">About</a>
                    <a href="{{ route('shop.contact') }}">Contact</a>
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
</body>
</html>
