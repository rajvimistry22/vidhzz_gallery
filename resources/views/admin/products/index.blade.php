@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="section-kicker">Admin Products</p>
                <h1 class="page-title">Manage products</h1>
            </div>
            <a href="{{ route('admin.products.create') }}" class="btn-primary">Add Product</a>
        </div>

        <form method="GET" class="grid gap-3 md:grid-cols-[1fr,220px,180px]">
            <input name="search" value="{{ request('search') }}" class="input" placeholder="Search product name or SKU">
            <select name="category" class="input">
                <option value="">All categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                @endforeach
            </select>
            <button class="btn-secondary">Filter</button>
        </form>

        <div class="panel overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-stone-50 text-stone-500">
                        <tr>
                            <th class="px-6 py-4">Product</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Subcategory</th>
                            <th class="px-6 py-4">Price</th>
                            <th class="px-6 py-4">Stock</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($products as $product)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-stone-950">{{ $product->name }}</p>
                                    <p class="text-xs text-stone-500">{{ $product->sku }}</p>
                                </td>
                                <td class="px-6 py-4">{{ $product->category?->name }}</td>
                                <td class="px-6 py-4">{{ $product->subcategory ?: '-' }}</td>
                                <td class="px-6 py-4">Rs. {{ number_format($product->price, 0) }}</td>
                                <td class="px-6 py-4">{{ $product->stock }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="text-sm font-semibold text-amber-700">Edit</a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-sm font-semibold text-rose-600" onclick="return confirm('Delete this product?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{ $products->links() }}
    </div>
@endsection
