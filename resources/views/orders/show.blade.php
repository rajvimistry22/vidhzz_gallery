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
                    <div class="flex justify-between"><span>Status</span><span class="font-semibold text-stone-900">{{ strtoupper($order->status) }}</span></div>
                    <div class="flex justify-between"><span>Payment</span><span class="font-semibold text-stone-900">{{ strtoupper($order->payment_status) }}</span></div>
                    <div class="h-px bg-stone-200 my-2"></div>
                    <div class="flex justify-between"><span>Subtotal</span><span class="font-semibold text-stone-900">Rs. {{ number_format($order->subtotal, 0) }}</span></div>
                    @if ($order->discount > 0)
                        <div class="flex justify-between"><span>Discount</span><span class="font-semibold text-red-600">- Rs. {{ number_format($order->discount, 0) }}</span></div>
                    @endif
                    <div class="flex justify-between"><span>Shipping</span><span class="font-semibold text-stone-900">Rs. {{ number_format($order->shipping_charge, 0) }}</span></div>
                    @if ($order->tax > 0)
                        <div class="flex justify-between"><span>Tax (3% GST)</span><span class="font-semibold text-stone-900">Rs. {{ number_format($order->tax, 0) }}</span></div>
                    @endif
                    <div class="flex justify-between border-t border-stone-200 pt-3 font-semibold text-stone-950 text-base"><span>Total</span><span class="text-amber-800 text-lg">{{ $order->formatted_total }}</span></div>
                </div>
                <a href="{{ route('orders.invoice', $order) }}" class="btn-primary mt-8 w-full block text-center text-sm font-semibold uppercase tracking-widest">Download Invoice</a>
            </aside>
        </div>
    </section>
</x-layouts.app>
