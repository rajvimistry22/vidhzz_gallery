<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        <p class="section-kicker">Collections</p>
        <h1 class="page-title">All product categories</h1>
        <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($categories as $category)
                <a href="{{ route('shop.category', $category) }}" class="panel overflow-hidden">
                    <img src="{{ $category->banner_url }}" alt="{{ $category->name }}" class="h-44 w-full object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-stone-950">{{ $category->name }}</h2>
                        <p class="mt-3 text-sm leading-7 text-stone-500">{{ $category->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-8">{{ $categories->links() }}</div>
    </section>
</x-layouts.app>
