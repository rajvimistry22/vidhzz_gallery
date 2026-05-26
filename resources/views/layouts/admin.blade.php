<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Vidhzz Gallery Admin' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-100">
    <div class="min-h-screen lg:grid lg:grid-cols-[280px,1fr]">
        <aside class="bg-stone-950 px-6 py-8 text-white">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-semibold tracking-[0.22em]">VIDHZZ GALLERY</a>
            <p class="mt-2 text-sm text-stone-400">Admin dashboard</p>
            <nav class="mt-10 space-y-3 text-sm">
                <a class="block rounded-2xl px-4 py-3 hover:bg-white/10" href="{{ route('admin.dashboard') }}">Overview</a>
                <a class="block rounded-2xl px-4 py-3 hover:bg-white/10" href="{{ route('admin.categories.index') }}">Categories</a>
                <a class="block rounded-2xl px-4 py-3 hover:bg-white/10" href="{{ route('admin.products.index') }}">Products</a>
                <a class="block rounded-2xl px-4 py-3 hover:bg-white/10" href="{{ route('admin.orders.index') }}">Orders</a>
                <a class="block rounded-2xl px-4 py-3 hover:bg-white/10" href="{{ route('admin.customers.index') }}">Customers</a>
                <a class="block rounded-2xl px-4 py-3 hover:bg-white/10" href="{{ route('admin.coupons.index') }}">Coupons</a>
                <a class="block rounded-2xl px-4 py-3 hover:bg-white/10" href="{{ route('admin.banners.index') }}">Banners</a>
                <a class="block rounded-2xl px-4 py-3 hover:bg-white/10" href="{{ route('admin.spin-wheel.index') }}">Spin & Win</a>
            </nav>
            <div class="mt-16 pt-6 border-t border-stone-800 space-y-2 text-sm">
                <a class="block rounded-2xl px-4 py-3 text-stone-400 hover:bg-white/10 hover:text-white transition" href="{{ route('shop.home') }}">← Visit Store</a>
                <form action="{{ route('logout') }}" method="POST" class="block w-full">
                    @csrf
                    <button type="submit" class="block w-full text-left rounded-2xl px-4 py-3 text-rose-400 hover:bg-rose-950/20 hover:text-rose-350 transition font-bold">Logout</button>
                </form>
            </div>
        </aside>
        <div class="p-4 sm:p-6 lg:p-10">
            <x-flash />
            @yield('content')
        </div>
    </div>
</body>
</html>
