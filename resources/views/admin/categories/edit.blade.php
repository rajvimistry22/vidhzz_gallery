@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="section-kicker">Admin Categories</p>
            <h1 class="page-title">Edit category</h1>
        </div>

        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data" class="panel p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')
            @include('admin.categories.form')
            <div class="flex gap-3">
                <button class="btn-primary">Update Category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Back</a>
            </div>
        </form>
    </div>
@endsection
