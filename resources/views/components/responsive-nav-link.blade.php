@props(['href' => null, 'isPcView' => false])

<div
    class="leading-4 font-medium text-brand-secondary-500 hover:text-brand-secondary-800 focus:outline-none transition ease-in-out duration-150 {{ $isPcView ? 'hidden md:block' : '' }}">
    <a {{ $attributes->merge(['class' => 'flex flex-col justify-end items-center hover:scale-105']) }} href="{{ $href }}" wire:navigate.hover>
        {{ $slot }}
    </a>
</div>
