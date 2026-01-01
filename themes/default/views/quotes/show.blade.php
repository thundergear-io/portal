<x-app-layout :title="$title ?? $quote->title">
    @php
        $currencySymbol = $quote->currencyModel?->prefix ?? '$';
    @endphp
    <div class="w-full flex flex-col lg:flex-row min-h-screen relative z-0">
        
        <!-- Left side -->
        <div class="w-full lg:w-1/2 lg:h-screen lg:sticky lg:top-0 bg-base-100 z-0">
            <!-- Background Illustration -->
            <div class="absolute top-0 -translate-y-64 left-1/2 -translate-x-1/2 blur-3xl pointer-events-none" aria-hidden="true">
                <div class="w-96 h-96 bg-primary/20 rounded-full"></div>
            </div>


            <div class="h-full w-full max-w-xl mx-auto flex flex-col justify-start px-6 sm:px-8 py-14 lg:py-24">
                <div class="flex flex-col justify-center flex-1 lg:fixed">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <h2 class="text-xl font-bold text-primary">Quote for</h2>
                            <span class="badge {{ $quote->status->value === 'approved' ? 'badge-success' : ($quote->status->value === 'declined' ? 'badge-error' : 'badge-warning') }}">
                                {{ ucfirst($quote->status->value) }}
                            </span>
                        </div>
                        <h1 class="text-3xl font-bold text-base-content leading-tight">{{ $quote->client_name ?? 'Client' }}</h1>
                        <time class="block text-md text-base-content/60">{{ optional($quote->start_date)->format('d M, Y') ?? 'TBD' }}</time>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side -->
        <main class="w-full lg:w-1/2 bg-base-200 text-base-content relative flex flex-col">
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
                    updatePosition();
                    window.addEventListener('scroll', () => updatePosition(), { passive: true });
                    window.addEventListener('resize', () => updatePosition(), { passive: true });
                "
                class="fixed inset-x-0 lg:left-1/2 lg:right-0 z-50 w-full lg:w-1/2 bg-base-100/95 backdrop-blur border-t border-base-300"
                :style="`bottom: calc(env(safe-area-inset-bottom) + ${bottomOffset}px)`"
            >
                <div class="w-full max-w-xl mx-auto px-6 sm:px-8">
                    <div class="flex py-5 md:py-7 gap-4">
                        @if ($quote->status === \App\Enums\QuoteStatus::Pending)
                            <button @click="showRejectModal = true" class="btn btn-error flex-1">Decline</button>
                            <button @click="showApproveModal = true" class="btn btn-success flex-1">Approve</button>
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
                <div x-show="showRejectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" x-cloak>
                    <div class="bg-base-100 rounded-xl shadow-xl max-w-md w-full p-6 space-y-4" @click.away="showRejectModal = false">
                        <h3 class="text-lg font-bold">Decline Quote</h3>
                        <form action="{{ $decisionUrl }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="decision" value="decline">
                            
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Reason for declining</span>
                                </label>
                                <select name="rejection_reason" class="select select-bordered w-full" required>
                                    <option value="" disabled selected>Select a reason</option>
                                    <option value="too_expensive">Too expensive</option>
                                    <option value="timeline_issues">Timeline issues</option>
                                    <option value="scope_mismatch">Scope mismatch</option>
                                    <option value="chose_competitor">Chose a competitor</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Additional comments</span>
                                </label>
                                <textarea name="rejection_message" class="textarea textarea-bordered h-24" placeholder="Please provide any additional feedback..."></textarea>
                            </div>

                            <div class="flex gap-3 pt-2">
                                <button type="button" @click="showRejectModal = false" class="btn btn-ghost flex-1">Cancel</button>
                                <button type="submit" class="btn btn-error flex-1">Decline Quote</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Approve Modal -->
                <div x-show="showApproveModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" x-cloak>
                    <div class="bg-base-100 rounded-xl shadow-xl max-w-md w-full p-6 space-y-4" @click.away="showApproveModal = false">
                        <h3 class="text-lg font-bold">Approve Quote</h3>
                        <form action="{{ $decisionUrl }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="decision" value="approve">
                            
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Select Payment Schedule</span>
                                </label>
                                <div class="space-y-3">
                                    <label class="flex items-start gap-3 p-3 border border-base-300 rounded-3xl cursor-pointer hover:bg-base-200 transition-colors">
                                        <input type="radio" name="payment_schedule" value="50_percent" class="radio radio-primary mt-1" checked>
                                        <div>
                                            <div class="font-semibold">50% Upfront Deposit</div>
                                            <div class="text-sm text-base-content/70">Pay {{ $currencySymbol }}{{ number_format($quote->total * 0.5, 2) }} now to start the project.</div>
                                        </div>
                                    </label>

                                    <label class="flex items-start gap-3 p-3 border border-base-300 rounded-3xl cursor-pointer hover:bg-base-200 transition-colors">
                                        <input type="radio" name="payment_schedule" value="100_percent" class="radio radio-primary mt-1">
                                        <div>
                                            <div class="font-semibold flex items-center gap-2">
                                                100% Upfront
                                                <span class="badge badge-sm badge-secondary">10% Discount</span>
                                            </div>
                                            <div class="text-sm text-base-content/70">
                                                Pay <span class="line-through">{{ $currencySymbol }}{{ number_format($quote->total, 2) }}</span> 
                                                <span class="font-bold text-success">{{ $currencySymbol }}{{ number_format($quote->total * 0.9, 2) }}</span> now.
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="flex gap-3 pt-2">
                                <button type="button" @click="showApproveModal = false" class="btn btn-ghost flex-1">Cancel</button>
                                <button type="submit" class="btn btn-success flex-1">Proceed to Terms</button>
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
                            <div class="card bg-base-100 shadow-sm border border-base-200">
                                <div class="card-body p-4">
                                    <h4 class="card-title text-sm text-base-content/70 font-medium">Start Date</h4>
                                    <time class="text-base-content">{{ optional($quote->start_date)->format('d M, Y') ?? 'TBD' }}</time>
                                </div>
                            </div>
                            <div class="card bg-base-100 shadow-sm border border-base-200">
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
                        <div class="join join-vertical w-full bg-base-100 shadow-sm rounded-3xl">
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

            <!-- Call to action -->
            {{-- <div class="sticky top-0 bottom-0 z-50 w-full bg-base-100/95 backdrop-blur border-t border-base-300" x-data="{ showRejectModal: false, showApproveModal: false }">
                <div class="w-full max-w-xl mx-auto px-6 sm:px-8">
                    <div class="flex py-5 md:py-7 gap-4">
                        @if ($quote->status === \App\Enums\QuoteStatus::Pending)
                            <button @click="showRejectModal = true" class="btn btn-error flex-1">Decline</button>
                            <button @click="showApproveModal = true" class="btn btn-success flex-1">Approve</button>
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
                <div x-show="showRejectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" x-cloak>
                    <div class="bg-base-100 rounded-xl shadow-xl max-w-md w-full p-6 space-y-4" @click.away="showRejectModal = false">
                        <h3 class="text-lg font-bold">Decline Quote</h3>
                        <form action="{{ $decisionUrl }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="decision" value="decline">
                            
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Reason for declining</span>
                                </label>
                                <select name="rejection_reason" class="select select-bordered w-full" required>
                                    <option value="" disabled selected>Select a reason</option>
                                    <option value="too_expensive">Too expensive</option>
                                    <option value="timeline_issues">Timeline issues</option>
                                    <option value="scope_mismatch">Scope mismatch</option>
                                    <option value="chose_competitor">Chose a competitor</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Additional comments</span>
                                </label>
                                <textarea name="rejection_message" class="textarea textarea-bordered h-24" placeholder="Please provide any additional feedback..."></textarea>
                            </div>

                            <div class="flex gap-3 pt-2">
                                <button type="button" @click="showRejectModal = false" class="btn btn-ghost flex-1">Cancel</button>
                                <button type="submit" class="btn btn-error flex-1">Decline Quote</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Approve Modal -->
                <div x-show="showApproveModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" x-cloak>
                    <div class="bg-base-100 rounded-xl shadow-xl max-w-md w-full p-6 space-y-4" @click.away="showApproveModal = false">
                        <h3 class="text-lg font-bold">Approve Quote</h3>
                        <form action="{{ $decisionUrl }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="decision" value="approve">
                            
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Select Payment Schedule</span>
                                </label>
                                <div class="space-y-3">
                                    <label class="flex items-start gap-3 p-3 border border-base-300 rounded-3xl cursor-pointer hover:bg-base-200 transition-colors">
                                        <input type="radio" name="payment_schedule" value="50_percent" class="radio radio-primary mt-1" checked>
                                        <div>
                                            <div class="font-semibold">50% Upfront Deposit</div>
                                            <div class="text-sm text-base-content/70">Pay {{ $currencySymbol }}{{ number_format($quote->total * 0.5, 2) }} now to start the project.</div>
                                        </div>
                                    </label>

                                    <label class="flex items-start gap-3 p-3 border border-base-300 rounded-3xl cursor-pointer hover:bg-base-200 transition-colors">
                                        <input type="radio" name="payment_schedule" value="100_percent" class="radio radio-primary mt-1">
                                        <div>
                                            <div class="font-semibold flex items-center gap-2">
                                                100% Upfront
                                                <span class="badge badge-sm badge-secondary">10% Discount</span>
                                            </div>
                                            <div class="text-sm text-base-content/70">
                                                Pay <span class="line-through">{{ $currencySymbol }}{{ number_format($quote->total, 2) }}</span> 
                                                <span class="font-bold text-success">{{ $currencySymbol }}{{ number_format($quote->total * 0.9, 2) }}</span> now.
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="flex gap-3 pt-2">
                                <button type="button" @click="showApproveModal = false" class="btn btn-ghost flex-1">Cancel</button>
                                <button type="submit" class="btn btn-success flex-1">Proceed to Terms</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}
        </main>
    </div>
</x-app-layout>