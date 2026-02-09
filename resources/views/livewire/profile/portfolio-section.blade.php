<x-section id="portfolio-section">

    {{-- Header area --}}
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-brand-secondary-900">
            Portfolios
        </h2>

        {{-- button to add a new portfolio --}}
        @if ($isOwner)
            <x-section.add-icon x-data=""
                x-on:click.stop="
                $dispatch('set-portfolio', { id: null })" />
        @endif
    </x-slot>

    {{-- portfolio section --}}

    {{-- Error State --}}
    @if ($hasError)
        <x-loading-error>Failed to load portfolios. Please try again.</x-loading-error>
    @endif

    {{-- Display portfolio below --}}
    @if (!$hasError)
        {{-- Display if portfolio data exists --}}
        @if (count($this->portfolios) > 0)
            <div class="splide pb-5" aria-label="Portfolio Showcase" wire:key="slider-{{ $lastUpdated }}"
                x-data="splideCarousel"
                data-splide='{
                    "type": "slide",
                    "padding": { "left": "10rem", "right": "10rem" },
                    "breakpoints": {
                        "1024": { "padding": { "left": "6rem", "right": "6rem" } },
                        "768": { "padding": { "left": "3rem", "right": "3rem" } },
                        "640": { "padding": { "left": "3rem", "right": "3rem" } }
                    }
                }'>
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($this->portfolios as $portfolio)
                            <li class="splide__slide py-4 px-2" wire:key="portfolio-slide-{{ $portfolio->id }}">
                                <div
                                    class="relative slider-content flex flex-col bg-white rounded-md shadow-md overflow-hidden border border-gray-100 transition hover:shadow-lg scale-75">

                                    {{-- Image --}}
                                    <div class="aspect-video w-full overflow-hidden bg-gray-200">
                                        <img src="{{ $portfolio->site_image_path ? asset("storage/{$portfolio->site_image_path}") : '/storage/site_photos/default.jpg' }}"
                                            alt="{{ $portfolio->title }}" class="w-full h-full object-cover">
                                    </div>

                                    {{-- Title and description --}}
                                    <div class="p-5 flex flex-col flex-grow">
                                        <h3 class="text-xl font-bold text-gray-800 mb-2 truncate">
                                            {{ $portfolio->title }}
                                        </h3>
                                        <p class="text-gray-600 text-sm font-light line-clamp-3 mb-2">
                                            {{ $portfolio->description }}
                                        </p>

                                        {{-- Link button --}}
                                        <div
                                            class="mt-auto pt-2 border-t border-gray-50 flex justify-start gap-3 sm:gap-5 items-center">
                                            <a href="{{ $portfolio->site_url }}"
                                                class="text-blue-600 text-sm font-medium hover:underline"
                                                target="blank">
                                                <img src="{{ asset('images/icons/site.svg') }}" alt="github-icon"
                                                    class="w-5 xl:hidden">
                                                <p class="hidden xl:inline">View Site</p>
                                            </a>
                                            <a href="{{ $portfolio->github_url }}"
                                                class="text-blue-600 text-sm font-medium hover:underline flex gap-2"
                                                target="blank">
                                                <img src="{{ asset('images/icons/github.svg') }}" alt="github-icon"
                                                    class="w-5 xl:hidden">
                                                <p class="hidden xl:inline">View Repository</p>
                                            </a>
                                        </div>
                                    </div>

                                    {{-- Show Edit icon for the owner --}}
                                    @if ($isOwner)
                                        <div class="absolute bottom-1 right-1 flex justify-end mt-2 min-w-5">
                                            <x-section.edit-icon
                                                x-on:click.stop="$dispatch('set-portfolio', { 
                                        id: {{ $portfolio->id }}
                                    })" />
                                        </div>
                                    @else
                                        <div class="absolute bottom-1 right-1 flex justify-end mt-2 min-w-5">
                                            <x-section.expand-icon
                                                x-on:click.stop="$dispatch('set-portfolio', { 
                                        id: {{ $portfolio->id }}
                                    })" />
                                        </div>
                                    @endif

                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            {{-- Display if no article exists --}}
            <x-no-data-to-display fileName="portfolio.svg">No portfolios to display</x-no-data-to-display>
        @endif
    @endif
</x-section>
