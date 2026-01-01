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
<fieldset class="flex flex-col w-full {{ $divClass ?? '' }}">
    @if ($label)
    <label for="{{ $name }}" class="mb-1 text-lg text-base-content">
        {{ $label }}
        @if ($required && !$hideRequiredIndicator)
        <span class="text-red-500">*</span>
        @endif
    </label>
    @endif

    <select id="{{ $id ?? $name }}" {{ $multiple ? 'multiple' : '' }} {{ $attributes->except(['options', 'id', 'name', 'multiple', 'class']) }}
        class="block px-4 w-full h-12 text-md text-base-content bg-base-300 border border-base-200
        rounded-2xl outline-none focus:outline-none transition-all duration-300 ease-in-out form-select disabled:bg-base-200/50 disabled:cursor-not-allowed ">
        @if (count($options) == 0 && $slot)
        {{ $slot }}
        @else
        @foreach ($options as $key => $option)
        <option class="text-md" value="{{ gettype($options) == 'array' ? $option : $key }}" {{ ($multiple && $selected ? in_array($key,
            $selected) : $selected==$option) ? 'selected' : '' }}>
            {{ $option }}</option>
        @endforeach
        @endif
    </select>
    @if ($multiple)
    <p class="text-xs text-base-content">
        {{ __('Pro tip: Hold down the Ctrl (Windows) / Command (Mac) button to select multiple options.') }}</p>
    @endif

    @error($name)
    <p class="text-red-500 text-xs">{{ $message }}</p>
    @enderror
</fieldset>