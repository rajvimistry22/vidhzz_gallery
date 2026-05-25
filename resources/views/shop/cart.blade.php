<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        <div class="grid gap-8 lg:grid-cols-[1fr,360px]">
            <div class="panel p-6 sm:p-8">
                <p class="section-kicker">Shopping Cart</p>
                <h1 class="mt-3 text-2xl font-semibold text-stone-950 sm:text-3xl">Review your order</h1>
                <div class="mt-8 space-y-6">
                    @forelse ($cart->items as $item)
                        <article class="grid gap-4 rounded-[1.75rem] border border-stone-200 p-4 sm:grid-cols-[120px,1fr]">
                            <img src="{{ $item->product->thumbnail }}" alt="{{ $item->product->name }}" class="h-32 w-full rounded-[1.25rem] object-cover">
                            <div class="flex flex-col justify-between gap-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h2 class="text-lg font-semibold text-stone-950">{{ $item->product->name }}</h2>
                                        <p class="mt-2 text-sm text-stone-500">{{ $item->variant?->size }} {{ $item->variant?->color }}</p>
                                        <p class="mt-1 text-sm font-semibold text-stone-900">Rs. {{ number_format($item->price, 0) }}</p>
                                    </div>
                                    <form action="{{ route('cart.items.destroy', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-sm font-semibold text-rose-600">Remove</button>
                                    </form>
                                </div>
                                <form action="{{ route('cart.items.update', $item) }}" method="POST" class="flex items-center gap-3">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" min="1" name="quantity" value="{{ $item->quantity }}" class="input max-w-24">
                                    <button class="btn-secondary">Update</button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-[1.75rem] border border-dashed border-stone-300 px-6 py-10 text-sm text-stone-500">Your cart is empty. Add products to continue.</div>
                    @endforelse
                </div>
            </div>

            <aside class="panel h-fit p-6 sm:p-8">
                <h2 class="text-2xl font-semibold text-stone-950">Order summary</h2>
                <div class="mt-6 space-y-4 text-sm text-stone-600">
                    <div class="flex justify-between"><span>Subtotal</span><span>Rs. {{ number_format($totals['subtotal'], 0) }}</span></div>
                    <div class="flex justify-between"><span>Discount</span><span>Rs. {{ number_format($totals['discount'], 0) }}</span></div>
                    <div class="flex justify-between"><span>Shipping</span><span>Rs. {{ number_format($totals['shipping'], 0) }}</span></div>
                    <div class="flex justify-between"><span>Tax</span><span>Rs. {{ number_format($totals['tax'], 0) }}</span></div>
                    <div class="flex justify-between border-t border-stone-200 pt-4 text-base font-semibold text-stone-950"><span>Total</span><span>Rs. {{ number_format($totals['total'], 0) }}</span></div>
                </div>

                <form action="{{ route('cart.coupon.apply') }}" method="POST" class="mt-6 space-y-3">
                    @csrf
                    <label class="label">Coupon Code</label>
                    <input name="code" class="input" placeholder="FESTIVE20" value="{{ $coupon?->code }}">
                    <button class="btn-secondary w-full">Apply Coupon</button>
                </form>

                @if ($coupon)
                    <form action="{{ route('cart.coupon.remove') }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button class="text-sm font-semibold text-stone-600">Remove coupon</button>
                    </form>
                @endif

                <a href="{{ route('checkout.index') }}" class="btn-primary mt-8 w-full {{ $cart->items->isEmpty() ? 'pointer-events-none opacity-50' : '' }}">Proceed to Checkout</a>
            </aside>
        </div>
    </section>
</x-layouts.app>
