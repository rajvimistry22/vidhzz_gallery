<x-layouts.app>
    <section class="container-shell py-10 sm:py-12">
        <div class="grid gap-8 lg:grid-cols-[0.8fr,1.2fr]">
            <div class="panel p-8">
                <p class="section-kicker">Contact</p>
                <h1 class="mt-4 text-3xl font-semibold text-stone-950 sm:text-4xl">Let's plan your festive order.</h1>
                <div class="mt-6 space-y-3 text-sm text-stone-600">
                    <p>Email: hello@vidhistudio.test</p>
                    <p>Phone: +91 98765 43210</p>
                    <p>Hours: Monday to Saturday, 10 AM to 7 PM</p>
                </div>
            </div>
            <div class="panel p-8">
                <form class="grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <label class="label">Name</label>
                        <input class="input">
                    </div>
                    <div class="sm:col-span-1">
                        <label class="label">Email</label>
                        <input class="input">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="label">Message</label>
                        <textarea rows="6" class="input"></textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <button type="button" class="btn-primary">Send Inquiry</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
