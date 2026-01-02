<div class="mx-auto px-4 py-12 sm:px-6 lg:max-w-7xl lg:px-8">
    <div class="lg:grid lg:grid-cols-4 lg:gap-x-12">
        <div class="lg:col-span-3 space-y-8">
            <div class="flex flex-col sm:flex-row gap-8 items-start bg-base-200/50 p-6 rounded-3xl border border-base-300">
                @if ($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full sm:w-48 aspect-4/3 object-contain rounded-2xl bg-base-300 shadow-lg">
                @endif
                <div class="flex-1 space-y-4">
                    <h1 class="text-3xl sm:text-4xl font-black text-base-content tracking-tight">{{ $product->name }}</h1>
                    <div class="prose prose-sm dark:prose-invert max-w-none text-base-content/70">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                @if ($product->availablePlans()->count() > 1)
                    <div class="bg-base-200/50 p-6 rounded-3xl border border-base-300">
                        <x-form.select wire:model.live="plan_id" name="plan_id" label="Select a billing term">
                            @foreach ($product->availablePlans() as $availablePlan)
                                <option value="{{ $availablePlan->id }}">
                                    {{ $availablePlan->name ?? ($availablePlan->billing_period . ' ' . ucfirst($availablePlan->billing_unit) . ($availablePlan->billing_period > 1 ? 's' : '')) }} -
                                    {{ $availablePlan->price()->formatted->price }}
                                    @if ($availablePlan->price()->has_setup_fee)
                                        + {{ $availablePlan->price()->formatted->setup_fee }} {{ __('product.setup_fee') }}
                                    @endif
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                @endif

                @if($product->configOptions->count() > 0 || count($this->getCheckoutConfig()) > 0)
                <div class="bg-base-200/50 p-6 sm:p-8 rounded-3xl border border-base-300 space-y-8">
                    <h3 class="text-xl font-black text-base-content flex items-center gap-3">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary text-black text-xs">2</span>
                        Configure Options
                    </h3>
                    
                    <div class="grid gap-8">
                        @foreach ($product->configOptions as $configOption)
                            @php
                                $showPriceTag = $configOption->children->filter(fn ($value) => !$value->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit)->is_free)->count() > 0;
                            @endphp
                            <x-form.configoption :config="$configOption" :name="'configOptions.' . $configOption->id" :showPriceTag="$showPriceTag" :plan="$plan">
                                @if ($configOption->type == 'select')
                                    @foreach ($configOption->children as $configOptionValue)
                                        <option value="{{ $configOptionValue->id }}">
                                            {{ $configOptionValue->name }}
                                            {{ ($showPriceTag && $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit)->available) ? ' - ' . $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit) : '' }}
                                        </option>
                                    @endforeach
                                @elseif($configOption->type == 'radio')
                                    <div class="grid gap-3">
                                        @foreach ($configOption->children as $configOptionValue)
                                            <div class="flex items-center gap-3">
                                                <input type="radio" id="{{ $configOptionValue->id }}" name="{{ $configOption->id }}"
                                                    class="radio radio-primary radio-sm"
                                                    wire:model.live="configOptions.{{ $configOption->id }}"
                                                    value="{{ $configOptionValue->id }}" />
                                                <label for="{{ $configOptionValue->id }}" class="text-sm font-medium text-base-content/70 cursor-pointer">
                                                    {{ $configOptionValue->name }}
                                                    {{ ($showPriceTag && $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit)->available) ? ' - ' . $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit) : '' }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </x-form.configoption>
                        @endforeach

                        @foreach ($this->getCheckoutConfig() as $configOption)
                            @php $configOption = (object) $configOption; @endphp
                            <x-form.configoption :config="$configOption" :name="'checkoutConfig.' . $configOption->name">
                                @if ($configOption->type == 'select')
                                    @foreach ($configOption->options as $configOptionValue => $configOptionValueName)
                                        <option value="{{ $configOptionValue }}">
                                            {{ $configOptionValueName }}
                                        </option>
                                    @endforeach
                                @elseif($configOption->type == 'radio')
                                    <div class="grid gap-3">
                                        @foreach ($configOption->options as $configOptionValue => $configOptionValueName)
                                            <div class="flex items-center gap-3">
                                                <input type="radio" id="{{ $configOptionValue }}" name="{{ $configOption->name }}"
                                                    class="radio radio-primary radio-sm"
                                                    wire:model.live="checkoutConfig.{{ $configOption->name }}"
                                                    value="{{ $configOptionValue }}" />
                                                <label for="{{ $configOptionValue }}" class="text-sm font-medium text-base-content/70 cursor-pointer">
                                                    {{ $configOptionValueName }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </x-form.configoption>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="mt-12 lg:mt-0">
            <div class="sticky top-24 bg-base-200 rounded-3xl p-4 border border-base-300 shadow-xl space-y-6">
                <h2 class="text-2xl font-black text-base-content tracking-tight">
                    {{ __('product.order_summary') }}
                </h2>
                
                <div class="space-y-4">
                    @if ($total->total_tax > 0)
                        <div class="flex justify-between text-sm font-bold text-base-content/40">
                            <span>{{ __('invoices.subtotal') }}</span>
                            <span class="text-base-content">{{ $total->format($total->subtotal) }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-base-content/40">
                            <span>{{ \App\Classes\Settings::tax()->name }} ({{ \App\Classes\Settings::tax()->rate }}%)</span>
                            <span class="text-base-content">{{ $total->formatted->total_tax }}</span>
                        </div>
                    @endif
                    
                    <div class="pt-4 border-t border-base-300">
                        <div class="flex flex-col items-baseline">
                            <span class="text-md font-black text-base-content/40">{{ __('product.total_today') }}</span>
                            <span class="text-3xl font-black text-primary tracking-tighter">{{ $total }}</span>
                        </div>
                    </div>

                    @if ($total->setup_fee && $plan->type == 'recurring')
                        <div class="p-4 bg-base-300/50 rounded-2xl border border-base-300">
                            <div class="text-[12px] font-black text-base-content/40 mb-1">
                                {{ __('product.then_after_x', ['time' => $plan->billing_period . ' ' . trans_choice(__('services.billing_cycles.' . $plan->billing_unit), $plan->billing_period)]) }}
                            </div>
                            <div class="text-xl font-black text-base-content">{{ $total->format($total->price) }}</div>
                        </div>
                    @endif
                </div>

                @if (($product->stock > 0 || !$product->stock) && $product->price()->available)
                    <div class="pt-4">
                        <x-button.primary wire:click="checkout" wire:loading.attr="disabled" class="w-full">
                            <x-loading target="checkout" />
                            <div wire:loading.remove wire:target="checkout">
                                {{ __('product.checkout') }}
                            </div>
                        </x-button.primary>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
