<button 
    {{ $attributes->merge(['class' => 'btn btn-secondary flex items-center gap-2 justify-center bg-base-200 text-base-content text-sm font-semibold border border-base-300 hover:bg-base-300 px-4 w-full duration-300 cursor-pointer disabled:cursor-not-allowed disabled:opacity-50']) }}>
    @if (isset($type) && $type === 'submit')
        <div role="status" wire:loading>
            <x-ri-loader-5-fill aria-hidden="true" class="size-6 me-2 fill-base-content animate-spin" />
            <span class="sr-only">Loading...</span>
        </div>
        <div wire:loading.remove>
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</button>
