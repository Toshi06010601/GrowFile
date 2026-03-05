@props(['href' => null])

@if ($href)
    <a href="{{ $href }}"
        {{ $attributes->merge([
            'class' =>
                'inline-block rounded-lg bg-white px-7 py-2 border-2 border-brand-secondary-300 text-center text-sm font-semibold text-brand-secondary-500 outline-none ring-green-300 transition duration-100 hover:bg-brand-secondary-100 focus-visible:ring active:text-brand-secondary-700 md:text-base',
            'wire:loading.attr' => 'disabled',
            'wire:offline.attr' => 'disabled',
            'wire:loading.class' => 'opacity-50 cursor-not-allowed bg-gray-400',
            'wire:offline.class' => 'opacity-50 cursor-not-allowed bg-gray-400',
        ]) }}>
        {{ $slot }}
    </a>
@else
    <button type="button"
        {{ $attributes->merge([
            'class' =>
                'inline-block rounded-lg bg-white px-7 py-2 border-2 border-brand-secondary-300 text-center text-sm font-semibold text-brand-secondary-500 outline-none ring-green-300 transition duration-100 hover:bg-brand-secondary-100 focus-visible:ring active:text-brand-secondary-700 md:text-base',
            'wire:loading.attr' => 'disabled',
            'wire:offline.attr' => 'disabled',
            'wire:loading.class' => 'opacity-50 cursor-not-allowed bg-gray-400',
            'wire:offline.class' => 'opacity-50 cursor-not-allowed bg-gray-400',
        ]) }}>
        {{ $slot }}
    </button>
@endif
