@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="section-kicker">Admin Categories</p>
                <h1 class="page-title">Manage categories</h1>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn-primary">Add Category</a>
        </div>

        <div class="panel overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-stone-50 text-stone-500">
                        <tr>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Slug</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Order</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($categories as $category)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-stone-950">{{ $category->name }}</p>
                                    <p class="text-xs text-stone-500">{{ \Illuminate\Support\Str::limit($category->description, 60) }}</p>
                                </td>
                                <td class="px-6 py-4">{{ $category->slug }}</td>
                                <td class="px-6 py-4">{{ $category->is_active ? 'Active' : 'Hidden' }}</td>
                                <td class="px-6 py-4">{{ $category->sort_order }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-sm font-semibold text-amber-700">Edit</a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-sm font-semibold text-rose-600" onclick="return confirm('Delete this category?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{ $categories->links() }}
    </div>
@endsection
