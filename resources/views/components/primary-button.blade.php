@props(['href' => null])

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'whitespace-nowrap inline-block rounded-lg border-2 border-brand-primary-950 bg-brand-primary-950 px-7 py-2 text-center text-sm font-semibold text-white outline-none ring-green-300 transition duration-100 hover:bg-green-800 focus-visible:ring active:bg-brand-primary-700 md:text-base']) }}>
        {{ $slot }}
    </a>
@else
    <button type="submit" {{ $attributes->merge(['class' => 'text-nowrap inline-block rounded-lg border-2 border-brand-primary-950 bg-brand-primary-950 px-6 py-2 text-center text-sm font-semibold text-white outline-none ring-green-300 transition duration-100 hover:bg-green-800 focus-visible:ring active:bg-brand-primary-700 md:text-base']) }}>
        {{ $slot }}
    </button>
@endif