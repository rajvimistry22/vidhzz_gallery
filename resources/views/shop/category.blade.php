<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        <div class="overflow-hidden rounded-[1.75rem] bg-stone-950 px-6 py-8 text-white sm:px-10">
            <p class="section-kicker text-amber-300">{{ $category->name }}</p>
            <h1 class="mt-3 text-3xl font-semibold sm:text-4xl">{{ $category->name }}</h1>
            <p class="mt-4 max-w-2xl text-sm leading-7 text-stone-300">{{ $category->description }}</p>
        </div>

        @if ($subcategories->isNotEmpty())
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('shop.category', $category) }}" class="filter-chip {{ request('subcategory') ? '' : 'filter-chip-active' }}">All</a>
                @foreach ($subcategories as $subcategory)
                    <a href="{{ route('shop.category', [$category, 'subcategory' => $subcategory] + request()->except('page', 'subcategory')) }}" class="filter-chip {{ request('subcategory') === $subcategory ? 'filter-chip-active' : '' }}">
                        {{ str($subcategory)->headline() }}
                    </a>
                @endforeach
            </div>
        @endif

        <div class="mt-8 grid gap-8 lg:grid-cols-[260px,1fr]">
            <aside class="panel p-5">
                <form method="GET" action="{{ route('shop.category', $category) }}" class="space-y-4">
                    <div>
                        <label class="label">Search</label>
                        <input name="search" value="{{ request('search') }}" class="input" placeholder="Search this category">
                    </div>
                    <div>
                        <label class="label">Subcategory</label>
                        <select name="subcategory" class="input">
                            <option value="">All</option>
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory }}" @selected(request('subcategory') === $subcategory)>{{ str($subcategory)->headline() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Sort</label>
                        <select name="sort" class="input">
                            <option value="">Featured</option>
                            <option value="price_asc" @selected(request('sort') === 'price_asc')>Price low to high</option>
                            <option value="price_desc" @selected(request('sort') === 'price_desc')>Price high to low</option>
                            <option value="popular" @selected(request('sort') === 'popular')>Popular</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <input name="min_price" value="{{ request('min_price') }}" class="input" placeholder="Min">
                        <input name="max_price" value="{{ request('max_price') }}" class="input" placeholder="Max">
                    </div>
                    <div class="space-y-3">
                        <button class="btn-primary w-full">Apply Filters</button>
                        <a href="{{ route('shop.category', $category) }}" class="btn-secondary w-full">Clear Filters</a>
                    </div>
                </form>
            </aside>

            <div>
                <div class="mb-5 flex items-center justify-between">
                    <p class="text-sm text-stone-500">{{ $products->total() }} products</p>
                </div>
                <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                    @forelse ($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <div class="panel p-10 text-sm text-stone-500 sm:col-span-2 xl:col-span-3">No products matched the selected filters.</div>
                    @endforelse
                </div>
                <div class="mt-8">{{ $products->links() }}</div>
            </div>
        </div>
    </section>
</x-layouts.app>
