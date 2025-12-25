@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-brand-secondary-700 ml-1']) }}>
    {{ $value ?? $slot }}
</label>
