@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="section-kicker">Customer Profile</p>
            <h1 class="page-title">{{ $customer->name }}</h1>
        </div>

        <div class="grid gap-6 xl:grid-cols-[360px,1fr]">
            <div class="panel p-6">
                <p class="text-sm text-stone-500">{{ $customer->email }}</p>
                <p class="mt-2 text-sm text-stone-500">{{ $customer->phone }}</p>
                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-stone-950">Addresses</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($customer->addresses as $address)
                            <div class="rounded-xl border border-stone-200 px-4 py-3 text-sm text-stone-600">{{ $address->full_address }}</div>
                        @empty
                            <p class="text-sm text-stone-500">No saved addresses.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="panel p-6">
                <h2 class="text-lg font-semibold text-stone-950">Order history</h2>
                <div class="mt-4 space-y-3">
                    @forelse ($customer->orders as $order)
                        <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between rounded-xl border border-stone-200 px-4 py-4">
                            <div>
                                <p class="font-semibold text-stone-950">{{ $order->order_number }}</p>
                                <p class="text-sm text-stone-500">{{ $order->created_at->format('d M Y') }}</p>
                            </div>
                            <p class="text-sm font-semibold text-stone-950">{{ $order->formatted_total }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-stone-500">No orders yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
