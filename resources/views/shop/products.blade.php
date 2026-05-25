<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        <div class="flex flex-col gap-6">
            <div>
                <p class="section-kicker">Shop All</p>
                <h1 class="page-title">Browse the full catalog</h1>
                <p class="mt-3 text-sm text-stone-500">
                    @if ($selectedCategory)
                        Showing products in {{ $selectedCategory->name }}.
                    @else
                        Explore every category from one place.
                    @endif
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('shop.products') }}" class="filter-chip {{ request('category') ? '' : 'filter-chip-active' }}">All</a>
                @foreach ($categories as $category)
                    <a href="{{ route('shop.products', array_merge(request()->except('page'), ['category' => $category->slug])) }}" class="filter-chip {{ request('category') === $category->slug ? 'filter-chip-active' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mt-8 grid gap-8 lg:grid-cols-[260px,1fr]">
            <aside class="panel p-5">
                <form method="GET" action="{{ route('shop.products') }}" class="space-y-4">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <div>
                        <label class="label">Search</label>
                        <input name="search" value="{{ request('search') }}" class="input" placeholder="Search product">
                    </div>
                    <div>
                        <label class="label">Subcategory</label>
                        <select name="subcategory" class="input">
                            <option value="">All subcategories</option>
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
                        <input name="min_price" value="{{ request('min_price') }}" class="input" placeholder="Min price">
                        <input name="max_price" value="{{ request('max_price') }}" class="input" placeholder="Max price">
                    </div>
                    <div class="space-y-3">
                        <button class="btn-primary w-full">Apply Filters</button>
                        <a href="{{ route('shop.products') }}" class="btn-secondary w-full">Clear Filters</a>
                    </div>
                </form>
            </aside>

            <div>
                <div class="mb-5 flex items-center justify-between">
                    <p class="text-sm text-stone-500">{{ $products->total() }} products found</p>
                </div>
                <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                    @forelse ($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <div class="panel p-10 text-sm text-stone-500 sm:col-span-2 xl:col-span-3">No products matched these filters.</div>
                    @endforelse
                </div>
                <div class="mt-8">{{ $products->links() }}</div>
            </div>
        </div>
    </section>
</x-layouts.app>
