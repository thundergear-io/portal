<x-app-layout :title="$title ?? 'Accept Terms'">
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
                            <span class="badge {{ $quote->status->value === 'approved' ? 'badge-success' : ($quote->status->value === 'declined' ? 'badge-error' : 'badge-warning') }}">
                                {{ ucfirst($quote->status->value) }}
                            </span>
                        </div>
                        <h1 class="text-3xl font-bold text-base-content">{{ $quote->client_name ?? 'Client' }}</h1>
                        <time class="block text-md text-base-content/60">{{ optional($quote->start_date)->format('d M, Y') ?? 'TBD' }}</time>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side (terms acceptance) -->
        <main class="w-full lg:w-1/2 bg-base-200 text-base-content">
            <div class="grow w-full max-w-xl mx-auto px-6 sm:px-8 py-14 lg:py-24 pb-36">
                <article class="space-y-12">
                    <section class="space-y-4">
                        <h3 class="text-lg font-bold">Before We Proceed</h3>
                        <p class="text-base-content/70 leading-relaxed">Please review and accept the key terms for this project. You can view the full terms and conditions in the quote.</p>
                        <a href="{{ route('quotes.show', ['quote' => $quote->public_id]) }}" class="link link-primary">View full terms and conditions</a>
                    </section>

                    <section>
                        <form action="{{ route('quotes.terms.accept', ['quote' => $quote->public_id]) }}" method="POST" class="space-y-8">
                            @csrf

                            <div class="space-y-6">
                                <label class="flex items-start gap-4 p-4 border border-base-300 rounded-xl bg-base-100 hover:border-primary/50 transition-colors cursor-pointer">
                                    <input type="checkbox" name="agree_scope" class="checkbox checkbox-primary mt-1" required>
                                    <span class="space-y-1">
                                        <span class="block font-semibold">Project Scope</span>
                                        <span class="block text-sm text-base-content/70 leading-relaxed">I agree to the scope and deliverables outlined in the brief.</span>
                                    </span>
                                </label>

                                <label class="flex items-start gap-4 p-4 border border-base-300 rounded-xl bg-base-100 hover:border-primary/50 transition-colors cursor-pointer">
                                    <input type="checkbox" name="agree_timeline" class="checkbox checkbox-primary mt-1" required>
                                    <span class="space-y-1">
                                        <span class="block font-semibold">Timeline</span>
                                        <span class="block text-sm text-base-content/70 leading-relaxed">I acknowledge the proposed timeline and understand adjustments may require change requests.</span>
                                    </span>
                                </label>

                                <label class="flex items-start gap-4 p-4 border border-base-300 rounded-xl bg-base-100 hover:border-primary/50 transition-colors cursor-pointer">
                                    <input type="checkbox" name="agree_payment" class="checkbox checkbox-primary mt-1" required>
                                    <span class="space-y-1">
                                        <span class="block font-semibold">Payment Terms</span>
                                        <span class="block text-sm text-base-content/70 leading-relaxed">I accept the payment terms associated with this quote.</span>
                                    </span>
                                </label>

                                <label class="flex items-start gap-4 p-4 border border-base-300 rounded-xl bg-base-100 hover:border-primary/50 transition-colors cursor-pointer">
                                    <input type="checkbox" name="agree_terms" class="checkbox checkbox-primary mt-1" required>
                                    <span class="space-y-1">
                                        <span class="block font-semibold">Terms & Conditions</span>
                                        <span class="block text-sm text-base-content/70 leading-relaxed">I agree to the full Terms & Conditions referenced above.</span>
                                    </span>
                                </label>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-error">
                                    <div>
                                        <span class="font-semibold">Please fix the following:</span>
                                        <ul class="list-disc ml-6 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <div class="pt-4">
                                <button class="btn btn-primary w-full btn-lg" type="submit">Accept Terms & Continue</button>
                            </div>
                        </form>
                    </section>
                </article>
            </div>
        </main>
    </div>
</x-app-layout>
