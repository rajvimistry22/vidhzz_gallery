<x-layouts.app>
    <section class="container-shell py-14 sm:py-20">
        <div class="mx-auto max-w-xl panel p-8 sm:p-10 shadow-[0_32px_80px_-48px_rgba(28,25,23,0.35)]">
            <p class="section-kicker">Register</p>
            <h1 class="mt-4 text-3xl font-semibold text-stone-950">Create your account</h1>
            <p class="mt-2 text-sm text-stone-500">Register to keep track of orders, save items to your wishlist, and check out faster.</p>
            
            <form action="{{ route('register.store') }}" method="POST" class="mt-8 grid gap-5 sm:grid-cols-2">
                @csrf
                <div>
                    <label class="label">Full name</label>
                    <input name="name" value="{{ old('name') }}" class="input" placeholder="e.g. Vaidehi Mistry">
                    @error('name')
                        <span class="text-red-650 text-xs mt-1.5 block font-medium">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label class="label">Phone (Optional)</label>
                    <input name="phone" value="{{ old('phone') }}" class="input" placeholder="e.g. +91 98765 43210">
                    @error('phone')
                        <span class="text-red-650 text-xs mt-1.5 block font-medium">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="sm:col-span-2">
                    <label class="label">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input" placeholder="e.g. vaidehi@example.com">
                    @error('email')
                        <span class="text-red-650 text-xs mt-1.5 block font-medium">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label class="label">Password</label>
                    <input type="password" name="password" class="input" placeholder="Min. 8 characters">
                    @error('password')
                        <span class="text-red-650 text-xs mt-1.5 block font-medium">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label class="label">Confirm password</label>
                    <input type="password" name="password_confirmation" class="input" placeholder="Re-enter password">
                    @error('password_confirmation')
                        <span class="text-red-650 text-xs mt-1.5 block font-medium">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="sm:col-span-2 mt-2">
                    <button class="btn-primary w-full py-3 text-base">Create Account</button>
                </div>
            </form>
            
            <div class="mt-8 border-t border-stone-100 pt-6 text-center">
                <p class="text-sm text-stone-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-semibold text-amber-700 hover:text-amber-800 hover:underline">Login here</a>
                </p>
            </div>
        </div>
    </section>
</x-layouts.app>
