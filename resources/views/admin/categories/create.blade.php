@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="section-kicker">Admin Categories</p>
            <h1 class="page-title">Add category</h1>
        </div>

        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="panel p-6 sm:p-8 space-y-6">
            @csrf
            @include('admin.categories.form')
            <div class="flex gap-3">
                <button class="btn-primary">Create Category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
