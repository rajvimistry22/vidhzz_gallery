@if (session('success') || session('warning') || $errors->any())
    <div class="container-shell pt-6">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif
        @if (session('warning'))
            <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-700">{{ session('warning') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                {{ $errors->first() }}
            </div>
        @endif
    </div>
@endif
