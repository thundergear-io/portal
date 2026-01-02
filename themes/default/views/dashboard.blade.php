<div class="container mt-20 mb-10">
    <x-navigation.breadcrumb />
    <p class="text-base-content/60 font mt-2 mb-8">
        {{ __('dashboard.dashboard_description') }}
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-8 items-start">

        <div class="grid gap-8 items-start">
            <!-- Active Services -->
            <div class="">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-base-100 border border-base-300 p-2 rounded-3xl">
                            <x-ri-archive-stack-fill class="size-5 text-accent" />
                        </div>
                        <h2 class="text-xl font-semibold">{{ __('dashboard.active_services') }}</h2>
                    </div>
                    <span class="bg-primary flex items-center justify-center font-semibold rounded-md size-5 text-sm text-black">
                        {{ Auth::user()->services()->where('status', 'active')->count() }}
                    </span>
                </div>
                <div class="space-y-4">
                    <livewire:services.widget status="active" />
                </div>
                <x-navigation.link class="btn btn-primary flex items-center text-black hover:bg-primary hover:text-black justify-center"
                    :href="route('services')">
                    {{ __('dashboard.view_all') }}
                    <x-ri-arrow-right-fill class="size-5" />
                </x-navigation.link>
            </div>

            <!-- Open Tickets -->
            @if(!config('settings.tickets_disabled', false))
            <div class="">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-base-100 border border-base-300 p-2 rounded-3xl">
                            <x-ri-customer-service-fill class="size-5 text-accent" />

                        </div>
                        <h2 class="text-xl font-semibold">{{ __('dashboard.open_tickets') }}</h2>
                        <a href="{{ route('tickets.create') }}" wire:navigate>
                            <x-ri-add-fill class="size-5 h-5" />
                        </a>
                    </div>
                    <span class="bg-primary flex items-center justify-center font-semibold rounded-md size-5 text-sm text-black">
                        {{ Auth::user()->tickets()->where('status', '!=', 'closed')->count() }}
                    </span>
                </div>
                <div class="space-y-4">
                    <livewire:tickets.widget />
                </div>
                <x-navigation.link class="btn btn-primary flex items-center text-black hover:bg-primary hover:text-black justify-center"
                    :href="route('tickets')">
                    {{ __('dashboard.view_all') }}
                    <x-ri-arrow-right-fill class="size-5 h-5" />
                </x-navigation.link>
            </div>
            @endif
        </div>

        <div class="grid gap-8 items-start">
            <!-- Unpaid Invoices -->
            <div class="">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-base-100 border border-base-300 p-2 rounded-3xl">
                            <x-ri-receipt-fill class="size-5 text-accent" />
                        </div>
                        <h2 class="text-xl font-semibold">{{ __('dashboard.unpaid_invoices') }}</h2>
                    </div>
                    <span class="bg-primary flex items-center justify-center font-semibold rounded-md size-5 text-sm text-black">
                        {{ Auth::user()->invoices()->where('status', 'pending')->count() }}
                    </span>
                </div>
                <div class="space-y-4">
                    <livewire:invoices.widget :limit="3" />
                </div>
                <x-navigation.link class="btn btn-primary flex items-center text-black hover:bg-primary hover:text-black justify-center"
                    :href="route('invoices')">
                    {{ __('dashboard.view_all') }}
                    <x-ri-arrow-right-fill class="size-5 h-5" />
                </x-navigation.link>
            </div>
            {!! hook('pages.dashboard') !!}
        </div>
    </div>
</div>
