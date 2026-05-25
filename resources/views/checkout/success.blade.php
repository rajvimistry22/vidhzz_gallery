<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        <div class="mx-auto max-w-2xl panel p-8 text-center">
            <p class="section-kicker">Order Success</p>
            <h1 class="mt-4 text-3xl font-semibold text-stone-950 sm:text-4xl">Thank you for shopping with Vidhzz Gallery.</h1>
            <p class="mt-4 text-sm text-stone-500">Your order {{ $order->order_number }} has been placed successfully.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('account.orders.show', $order) }}" class="btn-primary">View Order</a>
                <a href="{{ route('orders.invoice', $order) }}" class="btn-secondary">Download Invoice</a>
            </div>
        </div>
    </section>
</x-layouts.app>
