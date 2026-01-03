<x-app-layout :title="$title ?? 'Accept Terms'">
    <div class="flex flex-col lg:flex-row min-h-screen lg:-mt-20 relative z-0">

        <!-- Left side (same as show) -->
        <div class="w-full lg:w-1/2 lg:min-h-screen lg:sticky lg:top-0 bg-black z-0 overflow-hidden relative">
            <div class="absolute inset-0 pointer-events-none" id="beams-container"></div>

            <div class="h-full lg:min-h-screen w-full max-w-xl mx-auto flex flex-col justify-start px-4 sm:px-6 py-12 lg:py-20 relative z-10">
                <div class="grow flex flex-col justify-center">
                    <div class="rounded-3xl p-6 space-y-3">
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
        <main class="w-full lg:w-1/2 lg:mt-20 bg-base-200 text-base-content">
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
                                <div class="space-y-4">
                                    <h4 class="font-semibold">Select Payment Schedule</h4>
                                    <div class="space-y-3">
                                        <label class="flex items-start gap-3 p-4 border border-base-300 rounded-xl bg-base-100 hover:border-primary/50 transition-colors cursor-pointer">
                                            <input type="radio" name="payment_schedule" value="50_percent" class="radio radio-primary mt-1" checked>
                                            <div>
                                                <div class="font-semibold">50% Upfront Deposit</div>
                                                <div class="text-sm text-base-content/70">Pay {{ $quote->currencyModel?->prefix ?? '$' }}{{ number_format($quote->total * 0.5, 2) }} now to start the project.</div>
                                            </div>
                                        </label>

                                        <label class="flex items-start gap-3 p-4 border border-base-300 rounded-xl bg-base-100 hover:border-primary/50 transition-colors cursor-pointer">
                                            <input type="radio" name="payment_schedule" value="100_percent" class="radio radio-primary mt-1">
                                            <div>
                                                <div class="font-semibold flex items-center gap-2">
                                                    100% Upfront
                                                    <span class="badge badge-sm badge-secondary">10% Discount</span>
                                                </div>
                                                <div class="text-sm text-base-content/70">
                                                    Pay <span class="line-through">{{ $quote->currencyModel?->prefix ?? '$' }}{{ number_format($quote->total, 2) }}</span> 
                                                    <span class="font-bold text-success">{{ $quote->currencyModel?->prefix ?? '$' }}{{ number_format($quote->total * 0.9, 2) }}</span> now.
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="divider"></div>

                                <div class="space-y-2">
                                    <label class="flex items-start gap-3 p-3 border border-base-300 rounded-lg bg-base-100 hover:border-primary/50 transition-colors cursor-pointer">
                                        <input type="checkbox" name="agree_scope" class="checkbox checkbox-primary checkbox-sm mt-0.5" required>
                                        <span class="space-y-0.5">
                                            <span class="block font-semibold text-sm">Project Scope</span>
                                            <span class="block text-xs text-base-content/70 leading-relaxed">I agree to the scope and deliverables outlined in the brief.</span>
                                        </span>
                                    </label>

                                    <label class="flex items-start gap-3 p-3 border border-base-300 rounded-lg bg-base-100 hover:border-primary/50 transition-colors cursor-pointer">
                                        <input type="checkbox" name="agree_timeline" class="checkbox checkbox-primary checkbox-sm mt-0.5" required>
                                        <span class="space-y-0.5">
                                            <span class="block font-semibold text-sm">Timeline</span>
                                            <span class="block text-xs text-base-content/70 leading-relaxed">I acknowledge the proposed timeline and understand adjustments may require change requests.</span>
                                        </span>
                                    </label>

                                    <label class="flex items-start gap-3 p-3 border border-base-300 rounded-lg bg-base-100 hover:border-primary/50 transition-colors cursor-pointer">
                                        <input type="checkbox" name="agree_payment" class="checkbox checkbox-primary checkbox-sm mt-0.5" required>
                                        <span class="space-y-0.5">
                                            <span class="block font-semibold text-sm">Payment Terms</span>
                                            <span class="block text-xs text-base-content/70 leading-relaxed">I accept the payment terms associated with this quote.</span>
                                        </span>
                                    </label>

                                    <label class="flex items-start gap-3 p-3 border border-base-300 rounded-lg bg-base-100 hover:border-primary/50 transition-colors cursor-pointer">
                                        <input type="checkbox" name="agree_terms" class="checkbox checkbox-primary checkbox-sm mt-0.5" required>
                                        <span class="space-y-0.5">
                                            <span class="block font-semibold text-sm">Terms & Conditions</span>
                                            <span class="block text-xs text-base-content/70 leading-relaxed">I agree to the full Terms & Conditions referenced above.</span>
                                        </span>
                                    </label>
                                </div>
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
    @push('scripts')
        @vite('themes/' . config('settings.theme', 'default') . '/js/beams.js', config('settings.theme', 'default'))
    @endpush
</x-app-layout>
