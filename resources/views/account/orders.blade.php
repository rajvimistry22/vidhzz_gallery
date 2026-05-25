<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        <p class="section-kicker">Orders</p>
        <h1 class="page-title">Your order history</h1>
        <div class="mt-10 space-y-4">
            @foreach ($orders as $order)
                <a href="{{ route('account.orders.show', $order) }}" class="panel flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-stone-950">{{ $order->order_number }}</p>
                        <p class="mt-1 text-sm text-stone-500">{{ $order->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="flex items-center gap-6">
                        <span class="text-sm uppercase tracking-[0.16em] text-stone-400">{{ $order->status }}</span>
                        <span class="text-sm font-semibold text-stone-950">{{ $order->formatted_total }}</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-10">{{ $orders->links() }}</div>
    </section>
</x-layouts.app>
