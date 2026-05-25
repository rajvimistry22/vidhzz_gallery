<x-layouts.app>
    <section class="container-shell py-14 sm:py-20">
        <div class="mx-auto max-w-md panel p-8 sm:p-10 shadow-[0_32px_80px_-48px_rgba(28,25,23,0.35)]">
            <p class="section-kicker">Login</p>
            <h1 class="mt-4 text-3xl font-semibold text-stone-950">Welcome back</h1>
            <p class="mt-2 text-sm text-stone-500">Sign in to your account to track orders and save your wishlist.</p>
            
            <form action="{{ route('login.store') }}" method="POST" class="mt-8 space-y-5">
                @csrf
                <div>
                    <label class="label">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input" placeholder="e.g. name@example.com">
                    @error('email')
                        <span class="text-red-650 text-xs mt-1.5 block font-medium">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="label mb-0">Password</label>
                    </div>
                    <input type="password" name="password" class="input" placeholder="••••••••">
                    @error('password')
                        <span class="text-red-650 text-xs mt-1.5 block font-medium">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-3 text-sm text-stone-650 select-none cursor-pointer">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-stone-300 text-amber-700 focus:ring-amber-500">
                        Remember me
                    </label>
                </div>
                
                <button class="btn-primary w-full py-3 text-base">Sign In</button>
            </form>
            
            <div class="mt-8 border-t border-stone-100 pt-6 text-center">
                <p class="text-sm text-stone-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-semibold text-amber-700 hover:text-amber-800 hover:underline">Register now</a>
                </p>
            </div>
        </div>
    </section>
</x-layouts.app>
