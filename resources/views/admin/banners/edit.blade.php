@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="section-kicker">Admin Banners</p>
            <h1 class="page-title">Edit banner</h1>
        </div>
        <form method="POST" action="{{ route('admin.banners.update', $banner) }}" enctype="multipart/form-data" class="panel p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')
            @include('admin.banners.form')
            <div class="flex gap-3">
                <button class="btn-primary">Update Banner</button>
                <a href="{{ route('admin.banners.index') }}" class="btn-secondary">Back</a>
            </div>
        </form>
    </div>
@endsection
