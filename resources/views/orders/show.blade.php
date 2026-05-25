<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        <div class="grid gap-8 lg:grid-cols-[1fr,340px]">
            <div class="panel p-8">
                <p class="section-kicker">Order Details</p>
                <h1 class="mt-4 text-2xl font-semibold text-stone-950 sm:text-3xl">{{ $order->order_number }}</h1>
                <div class="mt-8 space-y-4">
                    @foreach ($order->items as $item)
                        <div class="flex items-center justify-between rounded-[1.5rem] border border-stone-200 px-5 py-4">
                            <div>
                                <p class="font-semibold text-stone-950">{{ $item->product_name }}</p>
                                <p class="text-sm text-stone-500">{{ $item->variant_info }}</p>
                            </div>
                            <p class="text-sm font-semibold text-stone-950">Rs. {{ number_format($item->subtotal, 0) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <aside class="panel p-8">
                <div class="space-y-3 text-sm text-stone-600">
                    <div class="flex justify-between"><span>Status</span><span>{{ $order->status }}</span></div>
                    <div class="flex justify-between"><span>Payment</span><span>{{ $order->payment_status }}</span></div>
                    <div class="flex justify-between"><span>Total</span><span>{{ $order->formatted_total }}</span></div>
                </div>
                <a href="{{ route('orders.invoice', $order) }}" class="btn-primary mt-8 w-full">Download Invoice</a>
            </aside>
        </div>
    </section>
</x-layouts.app>
