<x-section class="h-full" id="portfolio-section">
    {{-- Header area --}}
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-brand-secondary-900">
            portfolios
        </h2>

        {{-- button to add a new portfolio --}}
        @if ($isOwner)
            <x-section.add-icon x-data=""
                x-on:click="
                $dispatch('set-portfolio', { id: null , 
                isOwner: {{ $isOwner ? 'true' : 'false' }} });" />
        @endif
    </x-slot>

    {{-- portfolio section --}}

    {{-- Display portfolios below --}}
    <section class="splide" aria-label="Splide Basic HTML Example" data-splide='{"type":"loop","perPage":3}'>
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($portfolios as $portfolio)
                    <li class="splide__slide flex flex-col items-center">
                        <img src="{{ $portfolio->site_image_path }}" alt="portfolio site image">
                        <div class="text-center">
                            <h3 class="text-xl font-normal">{{ $portfolio->title }}</h3>
                            <p class="text-base font-light line-clamp-3">{{ $portfolio->description }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
</x-section>
