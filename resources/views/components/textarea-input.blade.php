@props(['disabled' => false])

<textarea @disabled($disabled) {{ $attributes->merge(['class' => 'border-brand-secondary-300 focus:border-brand-secondary-500 focus:ring-brand-secondary-500 rounded-md shadow-sm']) }}></textarea>
