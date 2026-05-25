<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
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
                <h1 class="mt-4 text-2xl font-semibold text-stone-950 sm:text-3xl">Shipping and billing details</h1>

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

                    {{-- Billing Address --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 py-2 border-b border-stone-100">
                            <input type="checkbox" id="copy-billing" x-model="copyBilling" class="h-4 w-4 rounded border-stone-300 text-amber-700 focus:ring-amber-500">
                            <label for="copy-billing" class="text-sm font-semibold text-stone-700 select-none">Billing same as shipping</label>
                        </div>

                        <div class="space-y-4" x-show="!copyBilling" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                            <h2 class="text-xl font-semibold text-stone-950">Billing Address</h2>
                            <div>
                                <input name="billing_name" x-model="billing_name" class="input" placeholder="Full name">
                                @error('billing_name')
                                    <span class="text-red-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <input name="billing_phone" x-model="billing_phone" class="input" placeholder="Phone number">
                                @error('billing_phone')
                                    <span class="text-red-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <textarea name="billing_address" x-model="billing_address" rows="3" class="input" placeholder="Address"></textarea>
                                @error('billing_address')
                                    <span class="text-red-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <input name="billing_city" x-model="billing_city" class="input" placeholder="City">
                                    @error('billing_city')
                                        <span class="text-red-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <input name="billing_state" x-model="billing_state" class="input" placeholder="State">
                                    @error('billing_state')
                                        <span class="text-red-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <input name="billing_pincode" x-model="billing_pincode" class="input" placeholder="Pincode">
                                @error('billing_pincode')
                                    <span class="text-red-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="p-6 rounded-[1.5rem] bg-stone-50 border border-stone-150 space-y-2" x-show="copyBilling" x-transition>
                            <p class="text-xs text-stone-500 font-semibold uppercase tracking-wider">Billing details snapshot</p>
                            <p class="text-sm font-medium text-stone-800" x-text="shipping_name || 'No name entered'"></p>
                            <p class="text-sm text-stone-600" x-text="shipping_phone || 'No phone number entered'"></p>
                            <p class="text-sm text-stone-600" x-text="shipping_address || 'No address entered'"></p>
                            <p class="text-sm text-stone-600" x-text="(shipping_city || '') + (shipping_state ? ', ' + shipping_state : '') + (shipping_pincode ? ' - ' + shipping_pincode : '')"></p>
                        </div>
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
                    <div class="flex justify-between border-t border-stone-100 pt-3 font-semibold text-stone-950 text-base"><span>Total</span><span class="text-amber-800 text-lg">Rs. {{ number_format($totals['total'], 0) }}</span></div>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
