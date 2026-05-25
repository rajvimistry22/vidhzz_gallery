<x-layouts.app>
    <section class="container-shell py-14" x-data="productDetail(@js($product->variants->map(fn($variant) => ['id' => $variant->id, 'label' => trim(($variant->size ? $variant->size . ' / ' : '') . ($variant->color ?? 'Standard'))])->values()))">
        <div class="grid gap-10 lg:grid-cols-[1.05fr,0.95fr]">
            <div
                class="space-y-4"
                x-data="productGallery(@js($product->gallery_urls))"
            >
                <div class="relative overflow-hidden rounded-[2rem] border border-stone-200/80 bg-white shadow-sm panel-float">
                    {{-- Main image --}}
                    <div class="relative w-full aspect-square sm:aspect-[4/3] md:aspect-square overflow-hidden bg-stone-50">
                        <template x-if="images.length">
                            <template x-for="(image, index) in images" :key="index">
                                <div
                                    class="absolute inset-0 w-full h-full cursor-zoom-in"
                                    x-show="activeIndex === index"
                                    x-transition:enter="transition-opacity duration-500"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition-opacity duration-300"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    @mousemove="handleMouseMove($event)"
                                    @mouseleave="handleMouseLeave()"
                                >
                                    <img
                                        :src="image"
                                        alt="{{ $product->name }}"
                                        class="h-full w-full object-cover transition-transform duration-100 ease-out"
                                        :class="isZoomed ? 'scale-[2.2]' : 'scale-100'"
                                        :style="isZoomed ? { transformOrigin: `${zoomX} ${zoomY}` } : {}"
                                        loading="eager"
                                        draggable="false"
                                    >
                                </div>
                            </template>
                        </template>

                        {{-- Fallback when gallery_urls is empty --}}
                        <template x-if="!images.length">
                            <div class="absolute inset-0 w-full h-full overflow-hidden">
                                <img
                                    src="{{ $product->primaryImage?->image_url ?? $product->thumbnail ?? '' }}"
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-cover"
                                    loading="eager"
                                    draggable="false"
                                >
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Thumbnails (only when multiple images exist) --}}
                <div class="grid grid-cols-4 gap-3" x-show="images.length > 1">
                    <template x-for="(image, index) in images" :key="'thumb-' + index">
                        <button
                            type="button"
                            class="aspect-square overflow-hidden rounded-2xl border-2 transition focus:outline-none"
                            :class="activeIndex === index ? 'border-amber-700 ring-2 ring-amber-700/20' : 'border-stone-200 hover:border-stone-350'"
                            @click="setActive(index)"
                            :aria-current="activeIndex === index ? 'true' : 'false'"
                        >
                            <img
                                :src="image"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover transition duration-300 hover:scale-105"
                                loading="lazy"
                                draggable="false"
                            >
                        </button>
                    </template>
                </div>
            </div>
            <div class="panel p-8">
                <p class="section-kicker">{{ $product->category->name }}</p>
                <h1 class="mt-4 text-4xl font-semibold text-stone-950">{{ $product->name }}</h1>
                <p class="mt-4 text-sm leading-7 text-stone-500">{{ $product->description }}</p>
                <div class="mt-6 flex items-center gap-3">
                    <span class="text-3xl font-semibold text-stone-950">Rs. {{ number_format($product->effective_price, 0) }}</span>
                    @if ($product->is_on_sale)
                        <span class="text-base text-stone-400 line-through">Rs. {{ number_format($product->price, 0) }}</span>
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">{{ $product->discount_percent }}% off</span>
                    @endif
                </div>
                <div class="mt-8 grid gap-5">
                    <div>
                        <p class="label">SKU</p>
                        <p class="text-sm text-stone-600">{{ $product->sku }}</p>
                    </div>
                    <div>
                        <p class="label">Available sizes</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach (($product->sizes ?? []) as $size)
                                <span class="rounded-full border border-stone-200 px-4 py-2 text-sm">{{ $size }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <p class="label">Available colors</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach (($product->colors ?? []) as $color)
                                <span class="rounded-full border border-stone-200 px-4 py-2 text-sm">{{ $color }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('cart.store') }}" class="mt-8 space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    @if ($product->variants->isNotEmpty())
                        <div>
                            <label class="label">Variant</label>
                            <select name="variant_id" class="input" x-model="selectedVariantId">
                                @foreach ($product->variants as $variant)
                                    <option value="{{ $variant->id }}">{{ trim(($variant->size ? $variant->size . ' / ' : '') . ($variant->color ?? 'Standard')) }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div>
                        <label class="label">Quantity</label>
                        <input type="number" min="1" name="quantity" value="1" class="input">
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button class="btn-primary">Add to Cart</button>
                        @auth
                            <button formaction="{{ route('wishlist.toggle', $product) }}" formmethod="POST" class="btn-secondary">Wishlist</button>
                        @endauth
                    </div>
                </form>
            </div>
        </div>

        <section class="mt-20">
            <div class="flex items-end justify-between">
                <div>
                    <p class="section-kicker">Related Products</p>
                    <h2 class="section-title">You may also love</h2>
                </div>
            </div>
            <div class="mt-10 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($relatedProducts as $relatedProduct)
                    <x-product-card :product="$relatedProduct" />
                @endforeach
            </div>
        </section>
    </section>
</x-layouts.app>
