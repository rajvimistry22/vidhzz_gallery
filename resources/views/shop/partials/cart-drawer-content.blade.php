@php
    $freeShippingLimit = 1999;
    $subtotal = (float) ($totals['subtotal'] ?? 0);
    $diff = $freeShippingLimit - $subtotal;
    $progress = min(100, ($subtotal / $freeShippingLimit) * 100);
@endphp

<div class="flex h-full flex-col">
    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-stone-150 px-6 py-5">
        <h3 class="text-lg font-semibold text-stone-950">Shopping Drawer ({{ $cart->items->sum('quantity') }})</h3>
        <button @click="cartOpen = false" class="text-stone-400 hover:text-stone-900 focus:outline-none">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>

    {{-- Free Shipping Progress Bar --}}
    <div class="bg-stone-50 border-b border-stone-150 px-6 py-4">
        @if ($diff > 0)
            <p class="text-xs text-stone-600 font-semibold mb-2">
                Add <span class="text-amber-800 font-bold">Rs. {{ number_format($diff, 0) }}</span> more to unlock <span class="uppercase text-amber-700 tracking-wider">Free Shipping!</span>
            </p>
        @else
            <p class="text-xs text-emerald-700 font-semibold mb-2 flex items-center gap-1">
                <span>🎉 Congratulations! You have unlocked FREE shipping!</span>
            </p>
        @endif
        <div class="h-1.5 w-full rounded-full bg-stone-200 overflow-hidden">
            <div class="h-full bg-amber-600 transition-all duration-500" style="width: {{ $progress }}%;"></div>
        </div>
    </div>

    {{-- Items List --}}
    <div class="flex-1 overflow-y-auto px-6 py-4 premium-scrollbar">
        @forelse ($cart->items as $item)
            <div class="flex items-start gap-4 py-4 border-b border-stone-100 last:border-0">
                <img src="{{ $item->product->thumbnail }}" alt="{{ $item->product->name }}" class="h-20 w-20 rounded-2xl object-cover border border-stone-100">
                <div class="flex-1 flex flex-col justify-between min-h-[80px]">
                    <div>
                        <div class="flex items-start justify-between gap-2">
                            <h4 class="text-sm font-semibold text-stone-950 leading-tight">
                                <a href="{{ route('shop.product', $item->product) }}" class="hover:text-amber-700 transition">{{ $item->product->name }}</a>
                            </h4>
                            <button @click="removeCartItem({{ $item->id }})" class="text-stone-400 hover:text-rose-600 transition focus:outline-none">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                        @if ($item->variant)
                            <p class="text-[11px] text-stone-400 uppercase tracking-wider mt-1">{{ trim(($item->variant->size ? 'Size: ' . $item->variant->size : '') . ($item->variant->color ? ' / Color: ' . $item->variant->color : '')) }}</p>
                        @endif
                    </div>
                    <div class="flex items-center justify-between gap-3 mt-3">
                        {{-- Quantity adjusters --}}
                        <div class="flex items-center border border-stone-200 rounded-full bg-stone-50 px-2 py-0.5">
                            <button @click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" class="px-2 py-0.5 text-stone-500 hover:text-stone-950 font-bold focus:outline-none" :disabled="{{ $item->quantity <= 1 ? 'true' : 'false' }}">-</button>
                            <span class="px-2 text-xs font-semibold text-stone-900 select-none">{{ $item->quantity }}</span>
                            <button @click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" class="px-2 py-0.5 text-stone-500 hover:text-stone-950 font-bold focus:outline-none">+</button>
                        </div>
                        <span class="text-sm font-semibold text-stone-950">Rs. {{ number_format($item->subtotal, 0) }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center h-64 text-center">
                <svg class="h-12 w-12 text-stone-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                <p class="text-sm text-stone-500 font-medium">Your shopping cart is empty.</p>
                <a href="{{ route('shop.products') }}" @click="cartOpen = false" class="btn-primary mt-4 py-2 px-6 text-xs uppercase tracking-widest">Start Shopping</a>
            </div>
        @endforelse
    </div>

    {{-- Footer Actions --}}
    @if ($cart->items->isNotEmpty())
        <div class="border-t border-stone-150 bg-stone-50 p-6 space-y-4">
            {{-- Coupon Section --}}
            <div x-data="{ code: '{{ $coupon?->code ?? '' }}' }">
                @if ($coupon)
                    <div class="flex items-center justify-between bg-emerald-50 border border-emerald-150 rounded-xl px-4 py-2.5 text-xs text-emerald-800">
                        <div class="flex items-center gap-1.5">
                            <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Active coupon: <strong class="tracking-wider">{{ $coupon->code }}</strong></span>
                        </div>
                        <button @click="removeCouponCode()" class="text-stone-400 hover:text-stone-700 font-bold focus:outline-none">✕</button>
                    </div>
                @else
                    <div class="flex gap-2">
                        <input x-model="code" class="input py-1.5 text-xs" placeholder="ENTER COUPON CODE" @keydown.enter.prevent="applyCouponCode(code)">
                        <button @click="applyCouponCode(code)" class="btn-secondary py-1.5 px-4 text-xs font-semibold uppercase tracking-wider">Apply</button>
                    </div>
                @endif
            </div>

            {{-- Price Summaries --}}
            <div class="space-y-2 text-sm text-stone-600">
                <div class="flex justify-between"><span>Subtotal</span><span class="font-semibold text-stone-900">Rs. {{ number_format($totals['subtotal'], 0) }}</span></div>
                @if (($totals['discount'] ?? 0) > 0)
                    <div class="flex justify-between"><span>Discount</span><span class="font-semibold text-red-600">- Rs. {{ number_format($totals['discount'], 0) }}</span></div>
                @endif
                <div class="flex justify-between"><span>Shipping</span><span class="font-semibold text-stone-900">
                    @if ($totals['shipping'] > 0)
                        Rs. {{ number_format($totals['shipping'], 0) }}
                    @else
                        <span class="text-emerald-700 font-semibold uppercase tracking-wider text-xs">Free</span>
                    @endif
                </span></div>
                @if (($totals['tax'] ?? 0) > 0)
                    <div class="flex justify-between"><span>Tax (3% GST)</span><span class="font-semibold text-stone-900">Rs. {{ number_format($totals['tax'], 0) }}</span></div>
                @endif
                <div class="flex justify-between border-t border-stone-200 pt-3 text-base font-semibold text-stone-950">
                    <span>Total</span>
                    <span class="text-amber-800 text-lg">Rs. {{ number_format($totals['total'], 0) }}</span>
                </div>
            </div>

            {{-- Checkout Button --}}
            <a href="{{ route('checkout.index') }}" class="btn-primary w-full py-3 text-center text-sm font-semibold uppercase tracking-widest block">
                Proceed to Checkout
            </a>
        </div>
    @endif
</div>
