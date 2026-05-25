@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="section-kicker">Admin Coupons</p>
            <h1 class="page-title">Edit coupon</h1>
        </div>
        <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}" class="panel p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')
            @include('admin.coupons.form')
            <div class="flex gap-3">
                <button class="btn-primary">Update Coupon</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn-secondary">Back</a>
            </div>
        </form>
    </div>
@endsection
