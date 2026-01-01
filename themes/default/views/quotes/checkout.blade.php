<x-app-layout :title="$title ?? 'Checkout'">
    <div class="flex flex-col lg:flex-row min-h-screen relative z-0">

        <!-- Left side (same as show) -->
        <div class="w-full lg:w-1/2 bg-red-500 lg:sticky lg:top-16 lg:overflow-y-auto z-0">
            <div class="absolute top-0 -translate-y-64 left-1/2 -translate-x-1/2 blur-3xl pointer-events-none" aria-hidden="true">
                <div class="w-96 h-96 bg-primary/20 rounded-full"></div>
            </div>

            <div class="min-h-full w-full max-w-xl mx-auto flex flex-col justify-start px-4 sm:px-6 py-12 lg:py-20">
                <div class="grow flex flex-col justify-center">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <h2 class="text-xl font-bold text-primary">Quote for</h2>
                            <span class="badge badge-success">Approved</span>
                        </div>
                        <h1 class="text-3xl font-bold text-base-content">{{ $quote->client_name ?? 'Client' }}</h1>
                        <time class="block text-md text-base-content/60">{{ optional($quote->start_date)->format('d M, Y') ?? 'TBD' }}</time>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side (checkout form) -->
        <main class="w-full lg:w-1/2 bg-base-200 text-base-content">
            <div class="grow w-full max-w-xl mx-auto px-4 sm:px-6 py-12 lg:py-20 pb-32">
                <article class="space-y-8">
                    <section>
                        <h3 class="text-lg font-bold mb-2">Project Summary</h3>
                        <div class="card bg-base-100 shadow-sm border border-base-300">
                            <div class="card-body p-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="font-semibold">{{ $quote->title }}</div>
                                        <div class="text-sm text-base-content/70">Total</div>
                                    </div>
                                    <div class="text-right font-semibold">${{ number_format($quote->total, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h3 class="text-lg font-bold mb-4">Checkout</h3>
                        <form action="{{ route('quotes.checkout.place', ['quote' => $quote->public_id]) }}" method="POST" class="space-y-4">
                            @csrf

                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Notes (optional)</span>
                                </div>
                                <textarea name="notes" class="textarea textarea-bordered bg-base-100 border-base-300" rows="4" placeholder="Add any reference or instructions"></textarea>
                            </label>

                            <div class="pt-2">
                                <button class="btn btn-primary w-full" type="submit">Proceed & Create Order</button>
                            </div>
                        </form>
                    </section>
                </article>
            </div>
        </main>
    </div>
</x-app-layout>
