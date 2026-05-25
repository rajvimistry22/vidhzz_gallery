<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        <div class="grid gap-8 lg:grid-cols-[0.8fr,1.2fr]">
            <div class="panel p-8">
                <p class="section-kicker">My Account</p>
                <h1 class="mt-4 text-2xl font-semibold text-stone-950 sm:text-3xl">{{ $user->name }}</h1>
                <p class="mt-3 text-sm text-stone-500">{{ $user->email }}</p>
                <p class="mt-1 text-sm text-stone-500">{{ $user->phone }}</p>
                <form action="{{ route('logout') }}" method="POST" class="mt-6">
                    @csrf
                    <button class="btn-secondary">Logout</button>
                </form>
            </div>
            <div class="panel p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="section-kicker">Recent Orders</p>
                        <h2 class="mt-3 text-2xl font-semibold text-stone-950">Order history overview</h2>
                    </div>
                    <a href="{{ route('account.orders') }}" class="text-sm font-semibold text-amber-700">View all</a>
                </div>
                <div class="mt-8 space-y-4">
                    @forelse ($orders as $order)
                        <a href="{{ route('account.orders.show', $order) }}" class="flex items-center justify-between rounded-[1.5rem] border border-stone-200 px-5 py-4">
                            <div>
                                <p class="text-sm font-semibold text-stone-950">{{ $order->order_number }}</p>
                                <p class="text-sm text-stone-500">{{ $order->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-stone-950">{{ $order->formatted_total }}</p>
                                <p class="text-xs uppercase tracking-[0.16em] text-stone-400">{{ $order->status }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-stone-500">No orders yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
