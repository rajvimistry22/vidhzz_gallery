<div
    x-show="cartOpen"
    class="fixed inset-0 z-50 overflow-hidden"
    style="display: none;"
    role="dialog"
    aria-modal="true"
>
    {{-- Backdrop blur overlay --}}
    <div
        x-show="cartOpen"
        x-transition:enter="transition-opacity ease-out duration-350"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm transition-opacity"
        @click="cartOpen = false"
    ></div>

    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
        {{-- Sliding panel --}}
        <div
            x-show="cartOpen"
            x-transition:enter="transform transition ease-out duration-400"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="pointer-events-auto w-screen max-w-md border-l border-stone-200 bg-white"
        >
            <div class="relative flex h-full flex-col shadow-2xl">
                {{-- Loading Spinner overlay --}}
                <div
                    x-show="loadingCart"
                    x-transition
                    class="absolute inset-0 z-30 flex items-center justify-center bg-white/70 backdrop-blur-[1px]"
                    style="display: none;"
                >
                    <div class="flex flex-col items-center gap-3">
                        <svg class="h-8 w-8 animate-spin text-amber-700" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-xs font-semibold text-stone-500 uppercase tracking-widest">Updating Cart...</span>
                    </div>
                </div>

                {{-- Dynamic content injected via Alpine JS --}}
                <div class="h-full" x-html="cartHtml">
                    {{-- Skeleton Loader default --}}
                    <div class="flex h-full flex-col p-6 animate-pulse">
                        <div class="h-8 bg-stone-100 rounded-full w-2/3 mb-6"></div>
                        <div class="h-4 bg-stone-100 rounded-full w-full mb-3"></div>
                        <div class="h-2.5 bg-stone-100 rounded-full w-1/2 mb-8"></div>
                        <div class="flex-1 space-y-4">
                            <div class="flex gap-4 items-center">
                                <div class="h-16 w-16 bg-stone-100 rounded-2xl"></div>
                                <div class="flex-1 space-y-2">
                                    <div class="h-4 bg-stone-100 rounded-full w-3/4"></div>
                                    <div class="h-3 bg-stone-100 rounded-full w-1/4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
