@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="section-kicker">Order Details</p>
            <h1 class="page-title">{{ $order->order_number }}</h1>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1fr,360px]">
            <div class="panel p-6">
                <h2 class="text-xl font-semibold text-stone-950">Items</h2>
                <div class="mt-6 space-y-4">
                    @foreach ($order->items as $item)
                        <div class="rounded-xl border border-stone-200 px-4 py-4">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-stone-950">{{ $item->product_name }}</p>
                                    <p class="text-sm text-stone-500">{{ $item->variant_info }}</p>
                                </div>
                                <p class="text-sm font-semibold text-stone-950">Rs. {{ number_format($item->subtotal, 0) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="panel p-6">
                <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="label">Order status</label>
                        <select name="status" class="input">
                            @foreach (['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'] as $status)
                                <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Payment status</label>
                        <select name="payment_status" class="input">
                            @foreach (['pending', 'paid', 'failed', 'refunded'] as $status)
                                <option value="{{ $status }}" @selected($order->payment_status === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Tracking number</label>
                        <input name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" class="input">
                    </div>
                    <button class="btn-primary w-full">Update Order</button>
                </form>
            </div>
        </div>
    </div>
@endsection
