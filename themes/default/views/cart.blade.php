<div class="mx-auto px-4 py-12 sm:px-6 container lg:px-8">
    <div class="flex flex-col lg:grid lg:grid-cols-4 gap-8">
        <div class="lg:col-span-3 space-y-6">
            @if (Cart::items()->count() === 0)
            <div class="bg-base-200/50 rounded-3xl p-12 text-center border border-base-300">
                <h1 class="text-3xl text-base-content">
                    {{ __('product.empty_cart') }}
                </h1>
                <a href="{{ route('home') }}" wire:navigate class="btn btn-primary mt-6">
                    Browse Catalog
                </a>
            </div>
            @endif
            
            @foreach (Cart::items() as $item)
            <div class="flex flex-col sm:flex-row justify-between w-full bg-base-200/50 p-6 sm:p-8 rounded-3xl border border-base-300 gap-6">
                <div class="flex flex-col gap-2">
                    <h2 class="text-2xl  text-base-content tracking-tight">
                        {{ $item->product->name }}
                    </h2>
                    <div class="text-sm font-bold text-base-content/40 space-y-1">
                        @foreach ($item->config_options as $option)
                        <div>{{ $option['option_name'] }}: <span class="text-base-content/70">{{ $option['value_name'] }}</span></div>
                        @endforeach
                    </div>
                </div>
                
                <div class="flex flex-col justify-between items-end gap-6">
                    <div class="text-right">
                        <div class="text-2xl  text-primary tracking-tighter">
                            {{ $item->price->format($item->price->total * $item->quantity) }}
                        </div>
                        @if ($item->quantity > 1)
                        <div class="text-xs font-bold text-base-content/40">
                            {{ $item->price }} each
                        </div>
                        @endif
                    </div>
                    
                    <div class="flex flex-wrap justify-end gap-3">
                        @if ($item->product->allow_quantity == 'combined')
                        <div class="flex items-center bg-base-300 rounded-2xl p-1 border border-base-300">
                            <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                class="btn btn-ghost btn-sm btn-square text-lg ">-</button>
                            <span class="px-4  text-base-content">{{ $item->quantity }}</span>
                            <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                class="btn btn-ghost btn-sm btn-square text-lg ">+</button>
                        </div>
                        @endif
                        
                        <a href="{{ route('products.checkout', [$item->product->category, $item->product, 'edit' => $item->id]) }}"
                            wire:navigate class="btn btn-ghost btn-sm">
                            {{ __('product.edit') }}
                        </a>
                        
                        <button wire:click="removeProduct({{ $item->id }})" class="btn btn-error btn-sm">
                            <x-loading target="removeProduct({{ $item->id }})" />
                            <span wire:loading.remove wire:target="removeProduct({{ $item->id }})">
                                {{ __('product.remove') }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="space-y-6">
            @if (Cart::items()->count() > 0)
            <div class="bg-base-200 rounded-3xl p-4 border border-base-300 shadow-xl space-y-6">
                <h2 class="text-2xl  text-base-content tracking-tight">
                    {{ __('product.order_summary') }}
                </h2>
                
                <div class="space-y-4">
                    <div class="flex flex-col gap-2">
                        @if(!$coupon)
                        <div class="flex gap-2 items-end">
                            <div class="flex-1">
                                <x-form.input wire:model="coupon" name="coupon" label="Coupon" placeholder="Enter code" />
                            </div>
                            <button wire:click="applyCoupon" class="btn btn-secondary h-12 rounded-2xl text-xs" wire:loading.attr="disabled">
                                <x-loading target="applyCoupon" />
                                <span wire:loading.remove wire:target="applyCoupon">{{ __('product.apply') }}</span>
                            </button>
                        </div>
                        @else
                        <div class="flex justify-between items-center bg-primary/10 p-4 rounded-2xl border border-primary/20">
                            <span class=" text-primary">{{ $coupon->code }}</span>
                            <button wire:click="removeCoupon" class="btn btn-ghost btn-xs text-error font-bold">
                                {{ __('product.remove') }}
                            </button>
                        </div>
                        @endif
                    </div>
                    
                    <div class="space-y-3 pt-4 border-t border-base-300">
                        <div class="flex justify-between text-sm text-base-content/40">
                            <span>{{ __('invoices.subtotal') }}</span>
                            <span class="text-base-content">{{ $total->format($total->subtotal) }}</span>
                        </div>
                        
                        @if ($total->tax > 0)
                        <div class="flex justify-between text-sm text-base-content/40">
                            <span>{{ \App\Classes\Settings::tax()->name }} ({{ \App\Classes\Settings::tax()->rate }}%)</span>
                            <span class="text-base-content">{{ $total->format($total->tax) }}</span>
                        </div>
                        @endif
                        
                        <div class="pt-4 border-t border-base-300">
                            <div class="flex justify-between items-baseline">
                                <span class="text-xl text-base-content/40">{{ __('invoices.total') }}</span>
                                <span class="text-3xl text-primary tracking-tighter">{{ $total->format($total->total) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    @if(config('settings.tos'))
                    <x-form.checkbox wire:model="tos" name="tos">
                        <span class="text-xs font-bold text-base-content/50">
                            {{ __('product.tos') }}
                            <a href="{{ config('settings.tos') }}" target="_blank" class="text-primary hover:underline">
                                {{ __('product.tos_link') }}
                            </a>
                        </span>
                    </x-form.checkbox>
                    @endif

                    <button wire:click="checkout" class="btn btn-primary w-full" wire:loading.attr="disabled">
                        <x-loading target="checkout" />
                        <span wire:loading.remove wire:target="checkout">{{ __('product.checkout') }}</span>
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
