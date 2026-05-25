@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="section-kicker">Admin Banners</p>
            <h1 class="page-title">Add banner</h1>
        </div>
        <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data" class="panel p-6 sm:p-8 space-y-6">
            @csrf
            @include('admin.banners.form')
            <div class="flex gap-3">
                <button class="btn-primary">Create Banner</button>
                <a href="{{ route('admin.banners.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
