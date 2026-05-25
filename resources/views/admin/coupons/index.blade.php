@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="section-kicker">Admin Coupons</p>
                <h1 class="page-title">Manage coupons</h1>
            </div>
            <a href="{{ route('admin.coupons.create') }}" class="btn-primary">Add Coupon</a>
        </div>

        <div class="panel overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-stone-50 text-stone-500">
                        <tr>
                            <th class="px-6 py-4">Code</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Value</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($coupons as $coupon)
                            <tr>
                                <td class="px-6 py-4 font-semibold text-stone-950">{{ $coupon->code }}</td>
                                <td class="px-6 py-4">{{ ucfirst($coupon->type) }}</td>
                                <td class="px-6 py-4">{{ $coupon->value }}</td>
                                <td class="px-6 py-4">{{ $coupon->is_active ? 'Active' : 'Inactive' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-3">
                                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-sm font-semibold text-amber-700">Edit</a>
                                        <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-sm font-semibold text-rose-600" onclick="return confirm('Delete this coupon?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{ $coupons->links() }}
    </div>
@endsection
