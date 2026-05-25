<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        <p class="section-kicker">Search</p>
        <h1 class="page-title">Results for "{{ $term ?: 'all products' }}"</h1>
        <form method="GET" class="mt-6 grid gap-3 md:grid-cols-3">
            <input name="q" value="{{ request('q') }}" class="input" placeholder="Search again">
            <select name="category" class="input">
                <option value="">All categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                @endforeach
            </select>
            <button class="btn-primary">Search</button>
        </form>
        <div class="mt-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="panel p-10 text-sm text-stone-500 sm:col-span-2 xl:col-span-3">No products found for your search.</div>
            @endforelse
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
    </section>
</x-layouts.app>
