@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="section-kicker">Admin Products</p>
            <h1 class="page-title">Edit product</h1>
        </div>

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="panel p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')
            @include('admin.products.form')
            <div class="flex gap-3">
                <button class="btn-primary">Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn-secondary">Back</a>
            </div>
        </form>
    </div>
@endsection
