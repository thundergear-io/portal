@props([
'name',
'label' => null,
'options' => [],
'selected' => null,
'multiple' => false,
'required' => false,
'divClass' => null,
'hideRequiredIndicator' => false,
])
<fieldset class="flex flex-col w-full {{ $divClass ?? '' }}" name="{{ $name }}">
    @if ($label)
    <label for="{{ $name }}" class="mb-2 text-sm font-bold text-base-content/40">
        {{ $label }}
        @if ($required && !$hideRequiredIndicator)
        <span class="text-error">*</span>
        @endif
    </label>
    @endif

    <div
        class="block px-4 py-4 w-full bg-base-200/50 border border-base-300 rounded-2xl outline-none focus-within:border-primary transition-all duration-300 ease-in-out">
        @if (count($options) == 0 && $slot)
        {{ $slot }}
        @else
        <div class="flex flex-col gap-3">
            @foreach ($options as $key => $option)
            <div class="flex items-center gap-3">
                <input type="radio" id="{{ $name }}_{{ $key }}" name="{{ $name }}"
                    class="radio radio-primary radio-sm"
                    value="{{ gettype($options) == 'array' ? $option : $key }}" {{ ($multiple && $selected ? in_array($key,
                    $selected) : $selected==$option) ? 'checked' : '' }} />
                <label for="{{ $name }}_{{ $key }}" class="text-sm font-medium text-base-content/70 cursor-pointer">
                    {{ $option }}
                </label>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    @error($name)
    <p class="text-error text-xs mt-1">{{ $message }}</p>
    @enderror
</fieldset>