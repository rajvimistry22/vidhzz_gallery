<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        @if ($spinCoupon && (!$coupon || $coupon->code !== $spinCoupon->code))
            <div class="mb-8 p-5 rounded-[2rem] border border-amber-200 bg-amber-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 animate-fade-in">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🎁</span>
                    <div>
                        <p class="text-sm font-semibold text-amber-900 font-serif">Unused Spin Wheel Discount Available!</p>
                        <p class="text-xs text-stone-600 mt-0.5">Apply your code <strong class="font-mono bg-white px-2 py-0.5 rounded border border-amber-200 text-amber-800">{{ $spinCoupon->code }}</strong> to get <strong class="font-bold text-amber-700">{{ $spinCoupon->spin_reward_label }}</strong> on this order.</p>
                    </div>
                </div>
                <form action="{{ route('cart.coupon.apply') }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    <input type="hidden" name="code" value="{{ $spinCoupon->code }}">
                    <button type="submit" class="w-full sm:w-auto rounded-full bg-amber-700 hover:bg-stone-950 px-6 py-2.5 text-xs font-semibold uppercase tracking-wider text-white transition duration-300">
                        Apply Coupon
                    </button>
                </form>
            </div>
        @endif

        <div class="grid gap-8 lg:grid-cols-[1fr,360px]">
            <form action="{{ route('checkout.store') }}" method="POST" class="panel p-6 sm:p-8" x-data="{
                copyBilling: true,
                shipping_name: @js(old('shipping_name', auth()->user()->name)),
                shipping_phone: @js(old('shipping_phone', auth()->user()->phone)),
                shipping_address: @js(old('shipping_address', '')),
                shipping_city: @js(old('shipping_city', '')),
                shipping_state: @js(old('shipping_state', '')),
                shipping_pincode: @js(old('shipping_pincode', '')),
                billing_name: @js(old('billing_name', auth()->user()->name)),
                billing_phone: @js(old('billing_phone', auth()->user()->phone)),
                billing_address: @js(old('billing_address', '')),
                billing_city: @js(old('billing_city', '')),
                billing_state: @js(old('billing_state', '')),
                billing_pincode: @js(old('billing_pincode', ''))
            }"
            x-effect="
                if (copyBilling) {
                    billing_name = shipping_name;
                    billing_phone = shipping_phone;
                    billing_address = shipping_address;
                    billing_city = shipping_city;
                    billing_state = shipping_state;
                    billing_pincode = shipping_pincode;
                }
            ">
                @csrf
                <p class="section-kicker">Checkout</p>
                <h1 class="mt-4 text-2xl font-semibold text-stone-950 sm:text-3xl">Shipping details</h1>


                @if ($errors->any())
                    <div class="mt-6 rounded-xl bg-red-50 p-4 border border-red-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <span class="text-red-800 font-semibold text-sm">Please correct the errors in the form below.</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mt-8 grid gap-8 lg:grid-cols-2">
                    {{-- Shipping Address --}}
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-stone-950">Shipping Address</h2>
                        <div>
                            <input name="shipping_name" x-model="shipping_name" class="input" placeholder="Full name">
                            @error('shipping_name')
                                <span class="text-red-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <input name="shipping_phone" x-model="shipping_phone" class="input" placeholder="Phone number">
                            @error('shipping_phone')
                                <span class="text-red-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <textarea name="shipping_address" x-model="shipping_address" rows="3" class="input" placeholder="Address"></textarea>
                            @error('shipping_address')
                                <span class="text-red-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <input name="shipping_city" x-model="shipping_city" class="input" placeholder="City">
                                @error('shipping_city')
                                    <span class="text-red-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <input name="shipping_state" x-model="shipping_state" class="input" placeholder="State">
                                @error('shipping_state')
                                    <span class="text-red-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <input name="shipping_pincode" x-model="shipping_pincode" class="input" placeholder="Pincode">
                            @error('shipping_pincode')
                                <span class="text-red-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Hidden Billing fields (billing = shipping) --}}
                    <div>
                        <input type="hidden" name="billing_name" :value="shipping_name">
                        <input type="hidden" name="billing_phone" :value="shipping_phone">
                        <input type="hidden" name="billing_address" :value="shipping_address">
                        <input type="hidden" name="billing_city" :value="shipping_city">
                        <input type="hidden" name="billing_state" :value="shipping_state">
                        <input type="hidden" name="billing_pincode" :value="shipping_pincode">
                    </div>
                </div>


                <div class="mt-8 border-t border-stone-100 pt-6">
                    <label class="label">Order notes (Optional)</label>
                    <textarea name="notes" rows="3" class="input" placeholder="Any special delivery instructions or gift notes">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="text-red-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                    @enderror
                </div>
                <button class="btn-primary w-full sm:w-auto mt-8 px-8 py-3 text-base">Continue to Payment</button>
            </form>

            <aside class="panel h-fit p-6 sm:p-8">
                <h2 class="text-2xl font-semibold text-stone-950">Order summary</h2>
                <div class="mt-6 space-y-4 max-h-[300px] overflow-y-auto pr-2">
                    @foreach ($cart->items as $item)
                        <div class="flex justify-between gap-4 text-sm text-stone-600">
                            <span class="font-medium text-stone-850">{{ $item->product->name }} <span class="text-xs text-stone-400">x{{ $item->quantity }}</span></span>
                            <span class="font-semibold text-stone-950">Rs. {{ number_format($item->subtotal, 0) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 space-y-3 border-t border-stone-200 pt-4 text-sm text-stone-600">
                    <div class="flex justify-between"><span>Subtotal</span><span class="font-semibold text-stone-900">Rs. {{ number_format($totals['subtotal'], 0) }}</span></div>
                    <div class="flex justify-between"><span>Discount</span><span class="font-semibold text-red-600">- Rs. {{ number_format($totals['discount'], 0) }}</span></div>
                    <div class="flex justify-between"><span>Shipping</span><span class="font-semibold text-stone-900">Rs. {{ number_format($totals['shipping'], 0) }}</span></div>
                    @if (($totals['tax'] ?? 0) > 0)
                        <div class="flex justify-between"><span>Tax (3% GST)</span><span class="font-semibold text-stone-900">Rs. {{ number_format($totals['tax'], 0) }}</span></div>
                    @endif
                    <div class="flex justify-between border-t border-stone-100 pt-3 font-semibold text-stone-950 text-base"><span>Total</span><span class="text-amber-800 text-lg">Rs. {{ number_format($totals['total'], 0) }}</span></div>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
