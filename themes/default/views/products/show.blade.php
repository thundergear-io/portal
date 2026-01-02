@php
    $plans = $product->availablePlans();
    $firstPlan = $plans->first();
@endphp

<div class="bg-base-100" x-data="{ 
    selectedPlan: {{ $firstPlan->id ?? 'null' }},
    plans: @js($plans->map(fn($plan) => [
        'id' => $plan->id,
        'price' => $plan->price()->formatted->price,
        'setup_fee' => $plan->price()->formatted->setup_fee,
        'total' => $plan->price()->formatted->total,
        'has_setup_fee' => $plan->price()->has_setup_fee,
        'name' => $plan->name ?? ($plan->billing_period . ' ' . ucfirst($plan->billing_unit) . ($plan->billing_period > 1 ? 's' : ''))
    ]))
}">
    <div class="mx-auto px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12">
            <!-- Left Side -->
            <div class="space-y-8">
                <!-- Image -->
                <div class="w-full">
                    @if ($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                        class="aspect-4/3 w-full rounded-3xl bg-base-200 object-contain shadow-xl border border-base-300" />
                    @else
                    <div class="aspect-4/3 w-full rounded-3xl bg-base-300 flex items-center justify-center shadow-xl border border-base-300">
                        <span class="text-base-content/50 text-xl font-medium">{{ __('product.no_image') }}</span>
                    </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-bold text-primary">{{ $category->name }}</span>
                        </div>
                        <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-base-content">{{ $product->name }}</h1>
                    </div>
                    
                    <div class="text-base text-md leading-relaxed text-base-content/70" x-data="{ expanded: false }">
                        <div x-show="!expanded">
                            {{ Str::limit(strip_tags($product->description), 250) }}
                            @if(strlen(strip_tags($product->description)) > 250)
                                <button @click="expanded = true" class="text-primary font-bold hover:underline ml-1 cursor-pointer text-md">Read More</button>
                            @endif
                        </div>
                        @if(strlen(strip_tags($product->description)) > 250)
                            <div x-show="expanded" x-cloak>
                                <div class="prose prose-md dark:prose-invert max-w-none">
                                    {!! $product->description !!}
                                </div>
                                <button @click="expanded = false" class="text-primary font-bold hover:underline mt-4 cursor-pointer block text-md">Show Less</button>
                            </div>
                        @endif
                    </div>


                </div>
            </div>

            <!-- Right Side -->
            <div class="mt-12 lg:mt-0">
                <div class="sticky top-24 space-y-8">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-black text-base-content mb-6 flex items-center gap-3">
                            <span class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full bg-primary text-black text-xs sm:text-sm">1</span>
                            Choose Billing Term
                        </h3>
                        <div class="grid gap-4">
                            @foreach ($plans as $plan)
                            <div @click="selectedPlan = {{ $plan->id }}" 
                                :class="selectedPlan == {{ $plan->id }} ? 'border-primary bg-primary/5 ring-2 ring-primary' : 'border-base-300 bg-base-100 hover:border-primary/50 hover:bg-base-200/50'"
                                class="relative flex cursor-pointer rounded-3xl border p-4 sm:p-6 shadow-sm focus:outline-none transition-all duration-300 group items-center gap-4 sm:gap-6 hover:scale-[1.02] active:scale-[0.98]">
                                
                                <!-- Radio Indicator -->
                                <div class="flex-shrink-0">
                                    <div :class="selectedPlan == {{ $plan->id }} ? 'border-primary bg-primary' : 'border-base-300 bg-base-100 group-hover:border-primary/50'"
                                        class="h-5 w-5 sm:h-6 sm:w-6 rounded-full border-2 flex items-center justify-center transition-all duration-300">
                                        <div x-show="selectedPlan == {{ $plan->id }}" class="h-2 w-2 sm:h-2.5 sm:w-2.5 rounded-full bg-primary-content"></div>
                                    </div>
                                </div>

                                <div class="flex flex-1 items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="block text-lg sm:text-xl font-black text-base-content group-hover:text-primary transition-colors">
                                            {{ $plan->name ?? ($plan->billing_period . ' ' . ucfirst($plan->billing_unit) . ($plan->billing_period > 1 ? 's' : '')) }}
                                        </span>
                                        <span class="mt-1 flex items-center text-[10px] lg:text-[12px] font-bold text-base-content/40">
                                            {{ $plan->type === 'free' ? 'Free' : ($plan->type === 'one-time' ? 'One-time' : 'Recurring') }}
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xl font-black text-primary">{{ $plan->price()->formatted->price }}</div>
                                        @if($plan->price()->setup_fee > 0)
                                        <div class="text-[10px] lg:text-[12px] font-bold text-base-content/40">+ {{ $plan->price()->formatted->setup_fee }} setup fee</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-20">
            <div class="bg-base-200 rounded-3xl p-6 sm:p-10 flex flex-col md:flex-row items-center justify-between gap-8 shadow-xl border border-base-300 relative overflow-hidden">
                <!-- Decorative background element -->
                <div class="absolute top-0 right-0 -mt-20 -mr-20 h-64 w-64 rounded-full bg-primary/5 blur-3xl"></div>
                
                <div class="flex flex-col items-center md:items-start relative z-10">
                    <span class="text-md font-black text-base-content/40 mb-2">Configuration Summary</span>
                    <div class="flex flex-col items-center md:items-start">
                        <div class="flex items-baseline gap-3">
                            <span class="text-4xl font-black text-base-content tracking-tighter" x-text="plans.find(p => p.id == selectedPlan)?.price || 'N/A'"></span>
                            <span class="text-sm sm:text-lg font-bold text-base-content/40" x-show="plans.find(p => p.id == selectedPlan)?.name" x-text="'/ ' + plans.find(p => p.id == selectedPlan)?.name"></span>
                        </div>
                        <div x-show="plans.find(p => p.id == selectedPlan)?.has_setup_fee" class="text-[10px] sm:text-xs font-bold text-base-content/40 mt-1">
                            Plus <span x-text="plans.find(p => p.id == selectedPlan)?.setup_fee"></span> setup fee
                        </div>
                    </div>
                </div>
                
                <div class="w-full md:w-auto relative z-10">
                    @if ($product->stock !== 0 && $product->price()->available)
                    <a :href="'{{ route('products.checkout', ['category' => $category, 'product' => $product->slug]) }}?plan=' + selectedPlan"
                        wire:navigate class="block w-full">
                        <button class="btn btn-primary btn-lg w-full px-10">
                            {{ __('product.add_to_cart') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </button>
                    </a>
                    @else
                    <div class="alert alert-warning rounded-3xl p-4 sm:p-6 border-2 border-warning/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <span class="text-base sm:text-lg font-bold">{{ __('product.out_of_stock', ['product' => $product->name]) }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>


    </div>
</div>