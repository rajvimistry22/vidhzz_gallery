@props(['product'])

<article 
    class="group relative flex h-full flex-col overflow-hidden rounded-[2rem] border border-stone-200/80 bg-white shadow-card transition-all duration-300 hover:-translate-y-2 hover:shadow-luxury"
    x-data="{ hovered: false }"
    @mouseenter="hovered = true"
    @mouseleave="hovered = false"
>
    {{-- Image Container --}}
    <div class="relative h-72 w-full overflow-hidden bg-stone-100 sm:h-80">
        <a href="{{ route('shop.product', $product) }}" class="block h-full w-full">
            {{-- Primary Image --}}
            <img 
                src="{{ $product->thumbnail }}" 
                alt="{{ $product->name }}" 
                class="absolute inset-0 h-full w-full object-cover transition-all duration-700 ease-out"
                :class="hovered && {{ count($product->gallery_urls) > 1 ? 'true' : 'false' }} ? 'scale-105 opacity-0' : 'scale-100 opacity-100'"
                loading="lazy"
            >
            
            {{-- Secondary Image on Hover --}}
            @if(count($product->gallery_urls) > 1)
                <img 
                    src="{{ $product->gallery_urls[1] }}" 
                    alt="{{ $product->name }}" 
                    class="absolute inset-0 h-full w-full object-cover transition-all duration-700 ease-out opacity-0"
                    :class="hovered ? 'scale-105 opacity-100' : 'scale-100 opacity-0'"
                    loading="lazy"
                >
            @endif
        </a>

        {{-- Luxury Badges (top-left) --}}
        <div class="absolute left-4 top-4 flex flex-col gap-1.5 z-10">
            @if ($product->is_new_arrival)
                <span class="inline-flex rounded-full border border-amber-600 bg-white/95 px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider text-amber-700 shadow-sm font-serif">New</span>
            @endif
            @if ($product->is_featured)
                <span class="inline-flex rounded-full border border-stone-900 bg-stone-900 px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider text-white shadow-sm font-serif">Bestseller</span>
            @endif
            @if ($product->is_trending)
                <span class="inline-flex rounded-full border border-rose-600 bg-white/95 px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider text-rose-600 shadow-sm font-serif">Trending</span>
            @endif
            @if ($product->sale_price)
                <span class="inline-flex rounded-full border border-emerald-600 bg-white/95 px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider text-emerald-700 shadow-sm font-serif">Festive Pick</span>
            @endif
        </div>

        {{-- Floating Heart Wishlist Button --}}
        <div class="absolute right-4 top-4 z-10">
            @auth
                <form method="POST" action="{{ route('wishlist.toggle', $product) }}">
                    @csrf
                    <button class="flex h-9 w-9 items-center justify-center rounded-full bg-white/90 border border-stone-200/80 text-stone-600 shadow-sm backdrop-blur-sm transition-all duration-300 hover:bg-white hover:text-rose-600 hover:scale-110 focus:outline-none">
                        <svg class="h-4 w-4" fill="{{ auth()->user()->wishlist()->where('product_id', $product->id)->exists() ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/90 border border-stone-200/80 text-stone-600 shadow-sm backdrop-blur-sm transition-all duration-300 hover:bg-white hover:text-rose-600 hover:scale-110">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </a>
            @endauth
        </div>

        {{-- Shimmer Hover effect overlay --}}
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/15 to-transparent -translate-x-full group-hover:animate-shimmer pointer-events-none z-10" style="background-size: 200% 100%;"></div>

        {{-- Quick Add Overlay (slides up on card hover) --}}
        <div class="absolute inset-x-4 bottom-4 z-10 transition-all duration-300 translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100">
            <form method="POST" action="{{ route('cart.store') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button class="w-full rounded-full bg-stone-950/95 py-2.5 text-center text-xs font-semibold uppercase tracking-widest text-white shadow-luxury backdrop-blur-sm transition duration-300 hover:bg-amber-700">
                    Quick Add
                </button>
            </form>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="flex flex-1 flex-col p-5 bg-white">
        <div class="space-y-1">
            <p class="text-[10px] uppercase tracking-[0.25em] text-stone-400 font-semibold">{{ $product->category->name }}</p>
            <a href="{{ route('shop.product', $product) }}" class="block text-sm font-semibold leading-tight text-stone-900 hover:text-amber-700 transition font-sans">{{ $product->name }}</a>
        </div>
        <p class="mt-2 min-h-[36px] text-xs leading-normal text-stone-500 line-clamp-2">{{ $product->short_description }}</p>
        <div class="mt-auto flex items-center justify-between pt-4 border-t border-stone-100">
            <div class="flex items-center gap-2">
                <span class="text-sm font-bold text-stone-950">Rs. {{ number_format($product->effective_price, 0) }}</span>
                @if ($product->is_on_sale)
                    <span class="text-[11px] text-stone-400 line-through">Rs. {{ number_format($product->price, 0) }}</span>
                @endif
            </div>
            
            <a href="{{ route('shop.product', $product) }}" class="text-[10px] uppercase tracking-wider font-semibold text-amber-700 hover:text-stone-950 transition">
                View Details →
            </a>
        </div>
    </div>
</article>
