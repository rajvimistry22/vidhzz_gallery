@extends('layouts.admin')

@section('content')
    <div class="space-y-8">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="panel p-6"><p class="text-sm text-stone-500">Revenue</p><h2 class="mt-2 text-3xl font-semibold">Rs. {{ number_format($stats['revenue'], 0) }}</h2></div>
            <div class="panel p-6"><p class="text-sm text-stone-500">Orders</p><h2 class="mt-2 text-3xl font-semibold">{{ $stats['orders'] }}</h2></div>
            <div class="panel p-6"><p class="text-sm text-stone-500">Customers</p><h2 class="mt-2 text-3xl font-semibold">{{ $stats['customers'] }}</h2></div>
            <div class="panel p-6"><p class="text-sm text-stone-500">Products</p><h2 class="mt-2 text-3xl font-semibold">{{ $stats['products'] }}</h2></div>
        </div>

        <section id="orders" class="panel p-6">
            <h2 class="text-2xl font-semibold text-stone-950">Recent Orders</h2>
            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="text-stone-400">
                        <tr><th class="pb-3">Order</th><th class="pb-3">Customer</th><th class="pb-3">Status</th><th class="pb-3">Total</th></tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($recentOrders as $order)
                            <tr>
                                <td class="py-4">{{ $order->order_number }}</td>
                                <td class="py-4">{{ $order->user->name }}</td>
                                <td class="py-4">{{ $order->status }}</td>
                                <td class="py-4">{{ $order->formatted_total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section id="products" class="panel p-6">
            <h2 class="text-2xl font-semibold text-stone-950">Low Stock Products</h2>
            <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($lowStockProducts as $product)
                    <div class="rounded-[1.5rem] border border-stone-200 p-4">
                        <p class="font-semibold text-stone-950">{{ $product->name }}</p>
                        <p class="mt-1 text-sm text-stone-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        <p class="mt-3 text-sm text-rose-600">Stock: {{ $product->stock }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="categories" class="panel p-6">
            <h2 class="text-2xl font-semibold text-stone-950">Categories</h2>
            <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                @foreach ($categories as $category)
                    <div class="rounded-[1.5rem] border border-stone-200 p-4">
                        <p class="font-semibold text-stone-950">{{ $category->name }}</p>
                        <p class="mt-2 text-sm text-stone-500">{{ $category->slug }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
