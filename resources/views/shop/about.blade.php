<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        <div class="grid gap-8 lg:grid-cols-[0.9fr,1.1fr]">
            <div class="panel p-8">
                <p class="section-kicker">About Vidhzz Gallery</p>
                <h1 class="mt-4 text-3xl font-semibold text-stone-950 sm:text-4xl">A premium handmade label rooted in Indian celebration culture.</h1>
            </div>
            <div class="panel p-8">
                <p class="muted-copy">Vidhzz Gallery brings together Navratri styling, artisan bangles, resin keepsakes, haldi accessories, and baby shower gifting in one elegant storefront. The experience is intentionally clean, modern, and mobile-first while still feeling warm and fashion-led.</p>
            </div>
        </div>
        <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-5">
            @foreach ($categories as $category)
                <div class="panel p-6">
                    <h2 class="text-xl font-semibold text-stone-950">{{ $category->name }}</h2>
                    <p class="mt-3 text-sm leading-7 text-stone-500">{{ $category->description }}</p>
                </div>
            @endforeach
        </div>
    </section>
</x-layouts.app>
