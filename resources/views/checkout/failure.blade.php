<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        <div class="mx-auto max-w-2xl panel p-8 text-center">
            <p class="section-kicker">Payment Failed</p>
            <h1 class="mt-4 text-3xl font-semibold text-stone-950 sm:text-4xl">We could not confirm the payment.</h1>
            <p class="mt-4 text-sm text-stone-500">Your order {{ $order->order_number }} is still saved. You can retry checkout from your account or cart.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('account.orders.show', $order) }}" class="btn-secondary">View Order</a>
                <a href="{{ route('cart.index') }}" class="btn-primary">Back to Cart</a>
            </div>
        </div>
    </section>
</x-layouts.app>
