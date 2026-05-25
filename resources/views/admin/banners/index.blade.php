@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="section-kicker">Admin Banners</p>
                <h1 class="page-title">Manage banners</h1>
            </div>
            <a href="{{ route('admin.banners.create') }}" class="btn-primary">Add Banner</a>
        </div>

        <div class="panel overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-stone-50 text-stone-500">
                        <tr>
                            <th class="px-6 py-4">Title</th>
                            <th class="px-6 py-4">Position</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($banners as $banner)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-stone-950">{{ $banner->title }}</p>
                                    <p class="text-xs text-stone-500">{{ $banner->subtitle }}</p>
                                </td>
                                <td class="px-6 py-4">{{ ucfirst($banner->position) }}</td>
                                <td class="px-6 py-4">{{ $banner->is_active ? 'Active' : 'Hidden' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-3">
                                        <a href="{{ route('admin.banners.edit', $banner) }}" class="text-sm font-semibold text-amber-700">Edit</a>
                                        <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-sm font-semibold text-rose-600" onclick="return confirm('Delete this banner?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{ $banners->links() }}
    </div>
@endsection
