<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        <div class="mx-auto max-w-2xl panel p-8 text-center">
            <p class="section-kicker">Secure Payment</p>
            <h1 class="mt-4 text-2xl font-semibold text-stone-950 sm:text-3xl">Complete payment for {{ $order->order_number }}</h1>
            <p class="mt-4 text-sm text-stone-500">Click below to open the Razorpay checkout securely.</p>
            <button id="rzp-button" class="btn-primary mt-8">Pay Rs. {{ number_format($order->total, 0) }}</button>
        </div>
    </section>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        const options = {
            key: @json($razorpayKey),
            amount: @json((int) round($order->total * 100)),
            currency: 'INR',
            name: 'Vidhzz Gallery',
            description: 'Order payment',
            order_id: @json($razorpayOrder['id']),
            handler: function (response) {
                const params = new URLSearchParams(response).toString();
                window.location.href = @json(route('checkout.success', $order)) + '?' + params;
            },
            modal: {
                ondismiss: function () {
                    window.location.href = @json(route('checkout.failure', $order));
                }
            }
        };

        document.getElementById('rzp-button').addEventListener('click', function () {
            new Razorpay(options).open();
        });
    </script>
</x-layouts.app>
