<div class="flex items-center {{ $divClass ?? '' }}">
    {{-- <input type="hidden" name="{{ $name }}" value="0" /> --}}
    <input type="checkbox" name="{{ $name }}" id="{{ $id ?? $name }}"
        {{ $attributes->except(['label', 'name', 'id', 'class', 'divClass', 'required']) }}
        class="checkbox checkbox-primary checkbox-sm rounded-lg" />
    <label class="ml-3 text-sm font-bold text-base-content/70 cursor-pointer" for="{{ $id ?? $name }}">
        @if(isset($label))
            {{ $label }}
        @else
            {{ $slot }}
        @endif
    </label>

    @error($name)
        <p class="text-error text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
