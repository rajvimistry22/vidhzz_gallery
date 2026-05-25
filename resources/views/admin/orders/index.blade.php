@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="section-kicker">Admin Orders</p>
            <h1 class="page-title">Manage orders</h1>
        </div>

        <form method="GET" class="max-w-xs">
            <select name="status" class="input" onchange="this.form.submit()">
                <option value="">All statuses</option>
                @foreach (['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </form>

        <div class="panel overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-stone-50 text-stone-500">
                        <tr>
                            <th class="px-6 py-4">Order</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Payment</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-stone-950">{{ $order->order_number }}</p>
                                    <p class="text-xs text-stone-500">{{ $order->created_at->format('d M Y') }}</p>
                                </td>
                                <td class="px-6 py-4">{{ $order->user?->name }}</td>
                                <td class="px-6 py-4">{{ ucfirst($order->status) }}</td>
                                <td class="px-6 py-4">{{ ucfirst($order->payment_status) }}</td>
                                <td class="px-6 py-4">{{ $order->formatted_total }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-semibold text-amber-700">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{ $orders->links() }}
    </div>
@endsection
