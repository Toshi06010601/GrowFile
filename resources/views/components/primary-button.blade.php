@props(['href' => null])

@if ($href)
    <a href="{{ $href }}"
        {{ $attributes->merge([
            'class' =>
                'whitespace-nowrap inline-block rounded-lg bg-brand-primary-950 px-7 py-2 text-center text-sm font-semibold text-white outline-none ring-green-300 transition duration-100 hover:bg-green-800 focus-visible:ring active:bg-brand-primary-700 md:text-base',
            'wire:loading.attr' => 'disabled',
            'wire:offline.attr' => 'disabled',
            'wire:loading.class' => 'opacity-50 cursor-not-allowed bg-gray-400',
            'wire:offline.class' => 'opacity-50 cursor-not-allowed bg-gray-400',
        ]) }}>
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->merge([
            'type' => 'submit',
            'class' =>
                'text-nowrap inline-block rounded-lg bg-brand-primary-950 px-6 py-2 text-center text-sm font-semibold text-white outline-none ring-green-300 transition duration-100 hover:bg-green-800 focus-visible:ring active:bg-brand-primary-700 md:text-base',
            'wire:loading.attr' => 'disabled',
            'wire:offline.attr' => 'disabled',
            'wire:loading.class' => 'opacity-50 cursor-not-allowed bg-gray-400',
            'wire:offline.class' => 'opacity-50 cursor-not-allowed bg-gray-400',
        ]) }}>
        {{ $slot }}
    </button>
@endif
