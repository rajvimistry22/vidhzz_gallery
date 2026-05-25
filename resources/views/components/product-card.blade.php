@props(['product'])

<article class="group flex h-full flex-col overflow-hidden rounded-[1.5rem] border border-stone-200/80 bg-white shadow-[0_16px_42px_-34px_rgba(28,25,23,0.4)] transition duration-300 hover:-translate-y-1" x-data="imageCarousel(@js($product->gallery_urls), 2000)">
    <a href="{{ route('shop.product', $product) }}" class="block">
        <div class="relative h-64 overflow-hidden bg-stone-100 sm:h-72">
            <template x-for="(image, index) in images" :key="index">
                <img
                    :src="image"
                    alt="{{ $product->name }}"
                    class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105"
                    x-show="activeIndex === index"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 scale-105"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-500"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                >
            </template>
            <div class="absolute left-4 top-4 flex gap-2">
                @if ($product->is_new_arrival)
                    <span class="badge-soft">New</span>
                @endif
                @if ($product->is_featured)
                    <span class="badge-soft">Featured</span>
                @endif
            </div>
            <div class="absolute bottom-4 left-1/2 flex -translate-x-1/2 gap-1.5" x-show="images.length > 1">
                <template x-for="(image, index) in images" :key="'dot-' + index">
                    <span class="h-1.5 rounded-full transition-all duration-300" :class="activeIndex === index ? 'w-5 bg-white' : 'w-1.5 bg-white/45'"></span>
                </template>
            </div>
        </div>
    </a>
    <div class="flex flex-1 flex-col gap-3 p-5">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-xs uppercase tracking-[0.22em] text-stone-400">{{ $product->category->name }}</p>
                <a href="{{ route('shop.product', $product) }}" class="mt-1 block text-base font-semibold leading-6 text-stone-900">{{ $product->name }}</a>
            </div>
            @auth
                <form method="POST" action="{{ route('wishlist.toggle', $product) }}">
                    @csrf
                    <button class="rounded-full border border-stone-200 px-3 py-2 text-xs font-semibold text-stone-700 transition hover:border-amber-700 hover:text-amber-700">Save</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="rounded-full border border-stone-200 px-3 py-2 text-xs font-semibold text-stone-700 transition hover:border-amber-700 hover:text-amber-700">Save</a>
            @endauth
        </div>
        <p class="min-h-[40px] text-sm leading-6 text-stone-500">{{ \Illuminate\Support\Str::limit($product->short_description, 72) }}</p>
        <div class="mt-auto flex items-center justify-between gap-3 pt-2">
            <div class="flex items-center gap-3">
                <span class="text-base font-semibold text-stone-950">Rs. {{ number_format($product->effective_price, 0) }}</span>
                @if ($product->is_on_sale)
                    <span class="text-xs text-stone-400 line-through">Rs. {{ number_format($product->price, 0) }}</span>
                @endif
            </div>
            <form method="POST" action="{{ route('cart.store') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button class="rounded-full bg-stone-950 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-white transition hover:bg-amber-700">Add</button>
            </form>
        </div>
    </div>
</article>
