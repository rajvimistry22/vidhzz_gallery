@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="section-kicker">Admin Products</p>
            <h1 class="page-title">Add product</h1>
        </div>

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="panel p-6 sm:p-8 space-y-6">
            @csrf
            @include('admin.products.form')
            <div class="flex gap-3">
                <button class="btn-primary">Create Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
