<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        <p class="section-kicker">Wishlist</p>
        <h1 class="page-title">Saved favorites</h1>
        <div class="mt-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="panel p-10 text-sm text-stone-500 sm:col-span-2 xl:col-span-3">Your wishlist is empty right now.</div>
            @endforelse
        </div>
    </section>
</x-layouts.app>
