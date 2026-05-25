@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="section-kicker">Admin Coupons</p>
            <h1 class="page-title">Add coupon</h1>
        </div>
        <form method="POST" action="{{ route('admin.coupons.store') }}" class="panel p-6 sm:p-8 space-y-6">
            @csrf
            @include('admin.coupons.form')
            <div class="flex gap-3">
                <button class="btn-primary">Create Coupon</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
