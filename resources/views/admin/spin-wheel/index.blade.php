@extends('layouts.admin')

@section('content')
    <div class="space-y-8">
        {{-- Header --}}
        <div>
            <p class="section-kicker">Interactive Promos</p>
            <h1 class="page-title">Spin & Win Results</h1>
        </div>

        {{-- Statistics Row --}}
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="panel p-6">
                <p class="text-sm text-stone-500 font-semibold uppercase tracking-wider">Total Spin Attempts</p>
                <h2 class="mt-2 text-3xl font-bold text-stone-900">{{ number_format($stats['total_spins']) }}</h2>
            </div>
            <div class="panel p-6">
                <p class="text-sm text-stone-500 font-semibold uppercase tracking-wider">Coupons Issued</p>
                <h2 class="mt-2 text-3xl font-bold text-amber-700">{{ number_format($stats['coupons_given']) }}</h2>
            </div>
            <div class="panel p-6">
                <p class="text-sm text-stone-500 font-semibold uppercase tracking-wider">Try Again Spins</p>
                <h2 class="mt-2 text-3xl font-bold text-stone-600">{{ number_format($stats['try_again_count']) }}</h2>
            </div>
            <div class="panel p-6">
                <p class="text-sm text-stone-500 font-semibold uppercase tracking-wider">Spins Today</p>
                <h2 class="mt-2 text-3xl font-bold text-emerald-700">{{ number_format($stats['today_spins']) }}</h2>
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            {{-- Prize Distribution Breakdown --}}
            <div class="panel p-6 lg:col-span-1 space-y-6">
                <h2 class="text-xl font-bold text-stone-950 font-serif">Reward Distribution</h2>
                <div class="space-y-4">
                    @foreach ($prizeBreakdown as $prize)
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="font-semibold text-stone-700">{{ $prize->reward_label }}</span>
                                <span class="font-bold text-stone-950">{{ $prize->count }} spins</span>
                            </div>
                            @php
                                $percent = $stats['total_spins'] > 0 ? ($prize->count / $stats['total_spins']) * 100 : 0;
                            @endphp
                            <div class="h-2 w-full rounded-full bg-stone-100 overflow-hidden">
                                <div class="h-full bg-amber-600 rounded-full" style="width: {{ $percent }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Recent Spins Log --}}
            <div class="panel p-6 lg:col-span-2 space-y-6">
                <h2 class="text-xl font-bold text-stone-950 font-serif">Recent Spins Log</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-stone-50 text-stone-500 font-semibold">
                            <tr>
                                <th class="px-4 py-3">Customer/Session</th>
                                <th class="px-4 py-3">Reward Won</th>
                                <th class="px-4 py-3">Coupon Code</th>
                                <th class="px-4 py-3">IP Address</th>
                                <th class="px-4 py-3">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse ($results as $result)
                                <tr class="hover:bg-stone-50/50 transition">
                                    <td class="px-4 py-3.5">
                                        @if ($result->user)
                                            <p class="font-semibold text-stone-900">{{ $result->user->name }}</p>
                                            <p class="text-xs text-stone-400">{{ $result->user->email }}</p>
                                        @else
                                            <p class="font-mono text-xs text-stone-500">Guest ({{ substr($result->session_id, 0, 10) }}...)</p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 font-medium text-stone-900">
                                        @if ($result->reward_label === 'Try Again')
                                            <span class="inline-flex rounded-full bg-stone-100 px-2 py-0.5 text-xs text-stone-500">Try Again</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-amber-100 px-2 py-0.5 text-xs text-amber-800 font-semibold">{{ $result->reward_label }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 font-mono text-sm text-stone-600">
                                        {{ $result->coupon_code ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3.5 text-stone-500 text-xs">
                                        {{ $result->ip_address ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3.5 text-stone-500 text-xs">
                                        {{ $result->created_at->format('M d, Y h:i A') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-stone-400">No spin entries recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $results->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
