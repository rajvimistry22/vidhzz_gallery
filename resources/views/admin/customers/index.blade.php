@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="section-kicker">Admin Customers</p>
            <h1 class="page-title">Manage customers</h1>
        </div>

        <div class="panel overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-stone-50 text-stone-500">
                        <tr>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Phone</th>
                            <th class="px-6 py-4">Orders</th>
                            <th class="px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($customers as $customer)
                            <tr>
                                <td class="px-6 py-4 font-semibold text-stone-950">{{ $customer->name }}</td>
                                <td class="px-6 py-4">{{ $customer->email }}</td>
                                <td class="px-6 py-4">{{ $customer->phone }}</td>
                                <td class="px-6 py-4">{{ $customer->orders_count }}</td>
                                <td class="px-6 py-4"><a href="{{ route('admin.customers.show', $customer) }}" class="text-sm font-semibold text-amber-700">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{ $customers->links() }}
    </div>
@endsection
