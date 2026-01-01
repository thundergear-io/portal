@props(['name', 'label' => null, 'required' => false, 'divClass' => null, 'class' => null,'placeholder' => null, 'id' => null, 'type' => null, 'hideRequiredIndicator' => false, 'dirty' => false])
<fieldset class="flex flex-col w-full {{ $divClass ?? '' }}">
    @if ($label)
        <label for="{{ $name }}" class="mb-1 text-lg text-base-content">
            {{ $label }}
            @if ($required && !$hideRequiredIndicator)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    <input type="{{ $type ?? 'text' }}" id="{{ $id ?? $name }}" name="{{ $name }}"
        class="block w-full text-md text-base-content bg-base-300 border border-base-200 rounded-2xl h-12 shadow-sm focus:outline-none transition-all duration-300 ease-in-out disabled:bg-base-300/50 disabled:cursor-not-allowed {{ $class ?? '' }} @if ($type !== 'color') px-4 py-4 @endif"
        placeholder="{{ $placeholder ?? ($label ?? '') }}"
        @if ($dirty && isset($attributes['wire:model'])) wire:dirty.class="!border-yellow-600" @endif
        {{ $attributes->except(['placeholder', 'label', 'id', 'name', 'type', 'class', 'divClass', 'required', 'hideRequiredIndicator', 'dirty']) }} @required($required) />
    @error($name)
        <p class="text-red-500 text-xs">{{ $message }}</p>
    @enderror
</fieldset>
