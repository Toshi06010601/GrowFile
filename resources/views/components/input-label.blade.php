@props(['value', 'required' => false])

<label {{ $attributes->merge(['class' => 'block font-medium text-brand-secondary-700 ml-1 relative']) }}>
    {{ $value ?? $slot }}
    @if($required) 
        <span class="text-red-600 ml-0.5" aria-hidden="true">*</span>
        <span class="sr-only">(Required)</span>
    @endif
</label>