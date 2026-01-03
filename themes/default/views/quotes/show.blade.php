<x-app-layout :title="$title ?? $quote->title">
    @php
        $currencySymbol = $quote->currencyModel?->prefix ?? '$';
    @endphp
    <div class="w-full flex flex-col lg:flex-row min-h-screen lg:-mt-20 relative z-0">
        
        <!-- Left side -->
        <div class="w-full lg:w-1/2 lg:min-h-screen lg:sticky lg:top-0 bg-black z-0 overflow-hidden relative">
            <!-- Background Illustration -->
            <div class="absolute inset-0 pointer-events-none" id="beams-container"></div>

            <div class="h-full lg:min-h-screen w-full max-w-xl mx-auto flex flex-col justify-center px-6 sm:px-8 py-14 lg:py-24 relative z-10">
                <div class="flex flex-col justify-center flex-1">
                    <div class="rounded-3xl p-4 space-y-4">
                        <div class="flex items-center gap-3">
                            <h2 class="text-xl font-bold text-primary">Quote for</h2>
                            <span class="badge {{ $quote->status->value === 'approved' ? 'badge-success' : ($quote->status->value === 'declined' ? 'badge-error' : 'badge-warning') }}">
                                {{ ucfirst($quote->status->value) }}
                            </span>
                        </div>
                        <h1 class="text-3xl font-bold text-base-content leading-tight">{{ $quote->client_name ?? 'Client' }}</h1>
                        <time class="block text-md text-base-content/80">{{ optional($quote->start_date)->format('d M, Y') ?? 'TBD' }}</time>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side -->
        <main 
            class="w-full lg:w-1/2 lg:mt-20 bg-base-200 text-base-content relative flex flex-col"
            x-data="{ 
                showRejectModal: false, 
                showApproveModal: false,
                bottomOffset: 0,
                ticking: false,
                updatePosition() {
                    if (!this.ticking) {
                        window.requestAnimationFrame(() => {
                            const footer = document.querySelector('footer');
                            if (footer) {
                                const rect = footer.getBoundingClientRect();
                                const visibleHeight = Math.max(0, window.innerHeight - rect.top);
                                this.bottomOffset = visibleHeight;
                            }
                            this.ticking = false;
                        });
                        this.ticking = true;
                    }
                }
            }"
            x-init="
                const observer = new ResizeObserver(() => updatePosition());
                observer.observe($el);
                updatePosition();
                window.addEventListener('scroll', () => updatePosition(), { passive: true });
                window.addEventListener('resize', () => updatePosition(), { passive: true });
            "
        >
            @if (session('quote_status'))
                <div class="mx-auto w-full max-w-xl px-4 sm:px-6 pt-6">
                    <div class="alert {{ session('quote_status') === 'approved' ? 'alert-success' : (session('quote_status') === 'declined' ? 'alert-error' : 'alert-warning') }}">
                        <div>
                            <span class="font-semibold">Quote status:</span>
                            <span class="capitalize">{{ str_replace('_', ' ', session('quote_status')) }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Call to action (fixed with dynamic offset to stay above footer) -->
            <div 
                class="fixed inset-x-0 lg:left-1/2 lg:right-0 z-50 w-full lg:w-1/2 bg-base-100 backdrop-blur border-t border-base-300"
                :style="`bottom: calc(env(safe-area-inset-bottom) + ${bottomOffset}px)`"
            >
                <div class="w-full max-w-xl mx-auto px-6 sm:px-8">
                    <div class="flex py-5 md:py-7 gap-4">
                        @if ($quote->status === \App\Enums\QuoteStatus::Pending)
                            <button @click="showRejectModal = true" class="btn btn-error flex-1">Decline</button>
                            <a href="{{ route('quotes.terms', ['quote' => $quote->public_id]) }}" class="btn btn-success flex-1">Approve</a>
                        @else
                            <div class="alert w-full">
                                <div class="font-semibold">This quote has been {{ $quote->status->value }}.</div>
                                @if ($quote->decided_at)
                                    <div class="text-sm text-base-content/70">{{ $quote->decided_at->diffForHumans() }}</div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Reject Modal -->
                <div x-show="showRejectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 sm:pb-4" x-cloak>
                    <div class="bg-base-100 rounded-3xl shadow-xl max-w-md w-full p-6 space-y-4 mb-90" @click.away="showRejectModal = false">
                        <h3 class="text-xl font-bold">Decline Quote</h3>
                        <form action="{{ $decisionUrl }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="decision" value="decline">
                            
                            <x-form.select name="rejection_reason" label="Reason for declining" required>
                                <option value="" disabled selected>Select a reason</option>
                                <option value="too_expensive">Too expensive</option>
                                <option value="timeline_issues">Timeline issues</option>
                                <option value="scope_mismatch">Scope mismatch</option>
                                <option value="chose_competitor">Chose a competitor</option>
                                <option value="other">Other</option>
                            </x-form.select>

                            <x-form.textarea name="rejection_message" label="Additional comments" placeholder="Please provide any additional feedback..." />

                            <div class="flex gap-3 pt-2">
                                <button type="button" @click="showRejectModal = false" class="btn btn-ghost flex-1">Cancel</button>
                                <button type="submit" class="btn btn-error flex-1">Decline Quote</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <div class="flex-1 w-full max-w-xl mx-auto px-6 sm:px-8 py-14 lg:py-24 pb-56">
                <article class="space-y-12 mb-6">
                    <section class="space-y-4">
                        <h3 class="text-lg font-bold">Brief</h3>
                        <div class="text-base-content/70 space-y-4 leading-relaxed">
                            {!! nl2br(e($quote->brief)) !!}
                        </div>
                    </section>

                    <section class="space-y-5">
                        <h3 class="text-lg font-bold">Details</h3>
                        <ul class="grid gap-5 sm:grid-cols-3 text-sm">
                            <div class="card bg-base-100 shadow-sm border border-base-300">
                                <div class="card-body p-4">
                                    <h4 class="card-title text-sm text-base-content/70 font-medium">Timeline</h4>
                                    <div class="text-base-content">{{ $quote->timeline ?? 'TBD' }}</div>
                                </div>
                            </div>
                            <div class="card bg-base-100 shadow-sm border border-base-300">
                                <div class="card-body p-4">
                                    <h4 class="card-title text-sm text-base-content/70 font-medium">Start Date</h4>
                                    <time class="text-base-content">{{ optional($quote->start_date)->format('d M, Y') ?? 'TBD' }}</time>
                                </div>
                            </div>
                            <div class="card bg-base-100 shadow-sm border border-base-300">
                                <div class="card-body p-4">
                                    <h4 class="card-title text-sm text-base-content/70 font-medium">End Date</h4>
                                    <time class="text-base-content">{{ optional($quote->end_date)->format('d M, Y') ?? 'TBD' }}</time>
                                </div>
                            </div>
                        </ul>
                    </section>

                    <section class="space-y-5">
                        <h3 class="text-lg font-bold">Costs Breakdown</h3>
                        <div class="overflow-x-auto">
                            <table class="table w-full text-sm">
                                <thead class="sr-only">
                                    <tr>
                                        <th>Description</th>
                                        <th scope="col">Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($quote->cost_items ?? [] as $item)
                                        <tr class="border-b border-base-200">
                                            <td class="px-4 py-5">
                                                <div class="font-semibold mb-1">{{ data_get($item, 'description') }}</div>
                                            </td>
                                            <td class="px-4 py-5 text-right font-semibold">{{ $currencySymbol }}{{ number_format((float) data_get($item, 'amount', 0), 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-4 py-5 text-base-content/60">No cost items provided.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="border-t border-base-200">
                                        <th scope="row" class="px-4 py-5 text-left font-normal">
                                            <p class="text-base-content/70 italic">Total in {{ $quote->currency }}</p>
                                        </th>
                                        <td class="px-4 py-5 text-right font-semibold text-base-content">{{ $currencySymbol }}{{ number_format($quote->total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </section>

                    <section class="space-y-5">
                        <h3 class="text-lg font-bold">Project Terms</h3>
                        <div class="join join-vertical w-full bg-base-100 border border-base-300 shadow-sm rounded-3xl">
                            @forelse ($quote->terms ?? [] as $index => $term)
                                <details class="collapse collapse-arrow join-item">
                                    <summary class="collapse-title text-lg font-medium">
                                        {{ data_get($term, 'title', 'Term ' . ($index + 1)) }}
                                    </summary>
                                    <div class="collapse-content text-base-content/70">
                                        <div class="prose prose-sm dark:prose-invert max-w-none pt-4 leading-relaxed">
                                            {!! data_get($term, 'content') !!}
                                        </div>
                                    </div>
                                </details>
                            @empty
                                <div class="text-base-content/70 italic">No specific terms provided.</div>
                            @endforelse
                        </div>
                    </section>
                </article>
            </div>

        </main>
    </div>
    @push('scripts')
        @vite('themes/' . config('settings.theme', 'default') . '/js/beams.js', config('settings.theme', 'default'))
    @endpush
</x-app-layout>