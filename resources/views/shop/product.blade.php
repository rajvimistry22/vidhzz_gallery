@php
    // Cross-sell logic: recommend from other categories
    $otherCategory = \App\Models\Category::where('id', '!=', $product->category_id)->active()->first();
    $completeLookProducts = $otherCategory 
        ? \App\Models\Product::active()->where('category_id', $otherCategory->id)->with('images')->take(3)->get()
        : \App\Models\Product::active()->where('id', '!=', $product->id)->with('images')->take(3)->get();
@endphp

<x-layouts.app>
    <section class="container-shell py-14" x-data="productDetail(@js($product->variants->map(fn($variant) => ['id' => $variant->id, 'label' => trim(($variant->size ? $variant->size . ' / ' : '') . ($variant->color ?? 'Standard'))])->values()))">
        <div class="grid gap-10 lg:grid-cols-[1.1fr,0.9fr]">
            
            {{-- Left column: Image Gallery --}}
            <div class="space-y-4" x-data="productGallery(@js($product->gallery_urls))">
                <div class="relative overflow-hidden rounded-[2.5rem] border border-stone-200/80 bg-white shadow-sm panel-float">
                    {{-- Main image with fluid magnifier zoom --}}
                    <div class="relative w-full aspect-square overflow-hidden bg-stone-50">
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

                        {{-- Fallback image --}}
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

                        {{-- Dynamic Badges --}}
                        <div class="absolute left-6 top-6 flex flex-col gap-1.5 z-10">
                            @if ($product->is_featured)
                                <span class="rounded-full bg-stone-900 px-3.5 py-1 text-[10px] font-bold uppercase tracking-wider text-white shadow-sm font-serif">Bestseller</span>
                            @endif
                            @if ($product->is_trending)
                                <span class="rounded-full bg-rose-600 px-3.5 py-1 text-[10px] font-bold uppercase tracking-wider text-white shadow-sm font-serif">Trending</span>
                            @endif
                            @if ($product->stock <= 5 && $product->stock > 0)
                                <span class="rounded-full bg-amber-600 px-3.5 py-1 text-[10px] font-bold uppercase tracking-wider text-white shadow-sm font-serif">Limited Edition</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Gallery Thumbnails --}}
                <div class="grid grid-cols-4 gap-3" x-show="images.length > 1">
                    <template x-for="(image, index) in images" :key="'thumb-' + index">
                        <button
                            type="button"
                            class="aspect-square overflow-hidden rounded-2xl border-2 transition focus:outline-none"
                            :class="activeIndex === index ? 'border-amber-700 ring-2 ring-amber-700/20' : 'border-stone-200 hover:border-stone-350'"
                            @click="setActive(index)"
                        >
                            <img
                                :src="image"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover transition duration-300 hover:scale-105"
                                loading="lazy"
                            >
                        </button>
                    </template>
                </div>
            </div>

            {{-- Right column: Product Info & Actions --}}
            <div class="panel p-8 sm:p-10 space-y-6">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-[0.25em] text-amber-700">{{ $product->category->name }}</span>
                    <h1 class="mt-3 text-3xl font-semibold text-stone-950 font-serif leading-tight sm:text-4xl">{{ $product->name }}</h1>
                    
                    {{-- Live popularity indicator --}}
                    <div class="mt-4 flex items-center gap-2 text-xs font-medium text-stone-500 bg-stone-50 p-2.5 rounded-xl border border-stone-150 w-fit">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                        </span>
                        <span>⚡ <strong class="text-stone-850" x-text="Math.floor(Math.random() * (15 - 5 + 1) + 5)">12</strong> fashion lovers are viewing this product right now</span>
                    </div>
                </div>

                <div class="flex items-center gap-4 py-2 border-y border-stone-100">
                    <span class="text-3xl font-bold text-stone-950">Rs. {{ number_format($product->effective_price, 0) }}</span>
                    @if ($product->is_on_sale)
                        <span class="text-lg text-stone-400 line-through">Rs. {{ number_format($product->price, 0) }}</span>
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700 font-serif">{{ $product->discount_percent }}% off</span>
                    @endif
                </div>

                <p class="text-sm leading-relaxed text-stone-600">{{ $product->description }}</p>

                {{-- Low stock urgency indicator --}}
                @if ($product->stock <= 5 && $product->stock > 0)
                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-xs font-semibold text-amber-800 flex items-center gap-2">
                        <span class="text-base">🔥</span>
                        <span>Only <strong class="text-amber-950">{{ $product->stock }}</strong> left in stock - order soon to avoid missing out!</span>
                    </div>
                @elseif ($product->stock == 0)
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-xs font-semibold text-rose-800 flex items-center gap-2">
                        <span class="text-base">🚫</span>
                        <span>Currently Sold Out. Join our VIP list to be notified on back-in-stock drops.</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('cart.store') }}" class="space-y-6 pt-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    @if ($product->variants->isNotEmpty())
                        <div>
                            <label class="label">Choose Variant</label>
                            <select name="variant_id" class="input py-2" x-model="selectedVariantId">
                                @foreach ($product->variants as $variant)
                                    <option value="{{ $variant->id }}">{{ trim(($variant->size ? $variant->size . ' / ' : '') . ($variant->color ?? 'Standard')) }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="flex gap-4">
                        <div class="w-1/3">
                            <label class="label">Quantity</label>
                            <div class="flex items-center border border-stone-200 rounded-xl bg-white px-2 py-1">
                                <button type="button" @click="decrement()" class="px-2 py-1 text-stone-500 font-bold focus:outline-none">-</button>
                                <input type="number" name="quantity" x-model.number="quantity" class="w-full text-center text-sm font-semibold border-0 p-0 focus:ring-0" min="1" readonly>
                                <button type="button" @click="increment()" class="px-2 py-1 text-stone-500 font-bold focus:outline-none">+</button>
                            </div>
                        </div>
                        <div class="flex-1 flex items-end gap-3">
                            <button class="btn-primary w-full py-3 bg-stone-950 text-white font-semibold uppercase tracking-wider hover:bg-amber-700 disabled:opacity-50" {{ $product->stock == 0 ? 'disabled' : '' }}>
                                Add to Cart
                            </button>
                            @auth
                                <button formaction="{{ route('wishlist.toggle', $product) }}" formmethod="POST" class="btn-secondary h-[44px] px-4 flex items-center justify-center text-stone-700 hover:text-rose-600 transition">
                                    <svg class="h-5 w-5" fill="{{ auth()->user()->wishlist()->where('product_id', $product->id)->exists() ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            @endauth
                        </div>
                    </div>
                </form>

                <div class="pt-6 grid grid-cols-2 gap-4 border-t border-stone-100 text-xs text-stone-500 font-medium">
                    <div class="flex items-center gap-2">📦 Free shipping above Rs. 1,999</div>
                    <div class="flex items-center gap-2">✨ 100% Handcrafted</div>
                    <div class="flex items-center gap-2">🛡️ Secured Payment Checkout</div>
                    <div class="flex items-center gap-2">📍 Ships from Gujarat</div>
                </div>
            </div>
        </div>

        {{-- Complete the Look Section (Cross-selling) --}}
        @if ($completeLookProducts->isNotEmpty())
            <section class="mt-24 border-t border-stone-200 pt-16">
                <div class="text-center space-y-2">
                    <p class="section-kicker">Couture Pairing</p>
                    <h2 class="section-title">Complete the Look</h2>
                    <p class="muted-copy mx-auto max-w-md">Pair your selection with these recommended handcrafted accessories.</p>
                </div>
                <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($completeLookProducts as $lookProduct)
                        <div class="panel p-4 flex gap-4 items-center hover-lift border border-stone-150">
                            <img src="{{ $lookProduct->thumbnail }}" alt="{{ $lookProduct->name }}" class="h-24 w-24 rounded-2xl object-cover border border-stone-100">
                            <div class="flex-1 space-y-1">
                                <h4 class="font-semibold text-stone-900 text-sm leading-snug">
                                    <a href="{{ route('shop.product', $lookProduct) }}" class="hover:text-amber-700 transition">{{ $lookProduct->name }}</a>
                                </h4>
                                <p class="text-xs text-stone-500 font-medium">{{ $lookProduct->category->name }}</p>
                                <div class="flex justify-between items-center pt-2">
                                    <span class="text-sm font-bold text-stone-950">Rs. {{ number_format($lookProduct->effective_price, 0) }}</span>
                                    <a href="{{ route('shop.product', $lookProduct) }}" class="text-[10px] uppercase font-bold text-amber-700 hover:text-stone-950 transition">View Details →</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Related Products --}}
        <section class="mt-24 border-t border-stone-200 pt-16">
            <div class="flex items-end justify-between border-b border-stone-200 pb-5">
                <div>
                    <p class="section-kicker">Related Products</p>
                    <h2 class="section-title">You may also love</h2>
                </div>
            </div>
            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($relatedProducts as $relatedProduct)
                    <x-product-card :product="$relatedProduct" />
                @endforeach
            </div>
        </section>

        {{-- Recently Viewed Products Component (localStorage driven) --}}
        <section
            x-data="recentlyViewedProducts()"
            x-init="addCurrentProduct(@js([
                'id' => $product->id,
                'name' => $product->name,
                'url' => route('shop.product', $product),
                'thumbnail' => $product->thumbnail,
                'price' => $product->effective_price
            ]))"
            class="mt-24 border-t border-stone-200 pt-16"
            x-show="list.length > 0"
            style="display: none;"
        >
            <div class="flex items-end justify-between border-b border-stone-200 pb-5 mb-10">
                <div>
                    <p class="section-kicker">Your History</p>
                    <h2 class="section-title">Recently Viewed</h2>
                </div>
                <button @click="clearHistory()" class="text-xs font-semibold text-stone-400 hover:text-rose-600 transition">Clear History</button>
            </div>
            <div class="grid gap-6 grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
                <template x-for="item in list" :key="item.id">
                    <div class="panel p-3 border border-stone-150 flex flex-col justify-between hover-lift">
                        <a :href="item.url" class="block aspect-square overflow-hidden rounded-xl bg-stone-50">
                            <img :src="item.thumbnail" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                        </a>
                        <div class="pt-3">
                            <a :href="item.url" class="text-xs font-semibold text-stone-900 leading-tight block truncate" x-text="item.name"></a>
                            <p class="text-xs text-amber-700 font-bold mt-1">Rs. <span x-text="Number(item.price).toLocaleString()"></span></p>
                        </div>
                    </div>
                </template>
            </div>
        </section>

        {{-- Sticky Mobile Add to Cart --}}
        <div
            class="fixed bottom-0 inset-x-0 z-30 bg-white border-t border-stone-200 p-4 flex items-center justify-between sm:hidden shadow-luxury"
            x-data="{ visible: false }"
            x-init="window.addEventListener('scroll', () => { visible = window.scrollY > 400 })"
            x-show="visible"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-y-full"
            x-transition:enter-end="translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-full"
            style="display: none;"
        >
            <div class="flex items-center gap-3">
                <img src="{{ $product->thumbnail }}" class="h-10 w-10 rounded-lg object-cover border border-stone-150">
                <div class="max-w-[150px]">
                    <p class="text-xs font-bold text-stone-900 truncate">{{ $product->name }}</p>
                    <p class="text-xs text-amber-700 font-bold mt-0.5">Rs. {{ number_format($product->effective_price, 0) }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('cart.store') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button class="btn-primary py-2.5 px-6 text-xs uppercase tracking-wider bg-stone-950 hover:bg-amber-700 text-white rounded-full font-semibold shadow-luxury disabled:opacity-50" {{ $product->stock == 0 ? 'disabled' : '' }}>
                    Add
                </button>
            </form>
        </div>

    </section>
</x-layouts.app>

<script>
function recentlyViewedProducts() {
    return {
        list: [],

        init() {
            this.list = JSON.parse(localStorage.getItem('recently_viewed_products') || '[]');
        },

        addCurrentProduct(product) {
            let items = JSON.parse(localStorage.getItem('recently_viewed_products') || '[]');
            // Filter out existing instances
            items = items.filter(item => item.id !== product.id);
            // Append current product to the front
            items.unshift(product);
            // Limit to top 6 items
            items = items.slice(0, 6);
            localStorage.setItem('recently_viewed_products', JSON.stringify(items));
            this.list = items;
        },

        clearHistory() {
            localStorage.removeItem('recently_viewed_products');
            this.list = [];
        }
    };
}
</script>
