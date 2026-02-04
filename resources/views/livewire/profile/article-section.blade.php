<x-section id="article-section">
    {{-- Header area --}}
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-brand-secondary-900">
            Published Articles
        </h2>

        {{-- button to add a new article --}}
        @if ($isOwner)
            <x-section.add-icon x-data=""
                x-on:click="
                $dispatch('set-article', { id: null });" />
        @endif
    </x-slot>

    {{-- article section --}}

    {{-- Display articles below --}}
    <div class="splide pb-5" aria-label="Portfolio Showcase"
        data-splide='{
        "perPage": 1,
        "direction": "ttb", 
        "height": "300px",
        "wheel": true,
        "wheelSleep": 500,
        "speed": 500,
        "wheelMinThreshold": 1,
        "pagination": false,
        "arrows": false,
        "releaseWheel": true,
        "flickPower": 1,
        "waitForTransition": true,
        "padding": { "top": "2rem", "bottom": "3rem" }
     }'
        wire:key="slider-{{ $lastUpdated }}" x-data="splideCarousel">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($articles as $article)
                    <li class="splide__slide py-1 h-full" wire:key="article-slide-{{ $article->id }}">
                        <div
                            class="relative slider-content h-full flex items-center bg-white rounded-md shadow-md overflow-hidden border border-brand-secondary-100 transition hover:shadow-lg">

                            {{-- Left: Content area --}}
                            <div class="flex-1 pl-3 py-2 flex flex-col">
                                {{-- Platform --}}
                                <p class="text-brand-secondary-500 text-xs line-clamp-1">
                                    Published in {{ $article->platform_name }}
                                </p>

                                {{-- Title --}}
                                <p class="text-base font-semibold text-brand-secondary-900 line-clamp-1">
                                    {{ $article->title }}
                                </p>

                                {{-- Description --}}
                                <p class="text-brand-secondary-600 text-sm flex-1 line-clamp-2">
                                    {{ $article->description }}
                                </p>

                                {{-- Date --}}
                                <div class="flex justify-end">
                                    <p class="text-brand-secondary-500 text-xs line-clamp-1">
                                        Published at {{ $article->published_date->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Right: Image (responsive) --}}
                            <div class="flex-shrink-0 p-2 sm:p-3">
                                <div class="w-32 sm:w-40 aspect-video overflow-hidden rounded-md bg-gray-100">
                                    <img src="{{ $article->article_image_path !== '' ? asset("storage/{$article->article_image_path}") : '/storage/article_photos/default.jpg' }}"
                                        alt="{{ $article->title }}" class="w-full h-full object-cover">
                                </div>
                            </div>

                            {{-- Action button --}}
                            @if ($isOwner)
                                <button type="button"
                                    @click.stop="$dispatch('set-article', { id: {{ $article->id }} })"
                                    class="absolute bottom-1 right-1 p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-md hover:bg-white hover:shadow-lg transition-all">
                                    <svg class="w-4 h-4 text-brand-secondary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            @else
                                <button type="button"
                                    @click.stop="$dispatch('set-article', { id: {{ $article->id }} })"
                                    class="absolute bottom-1 right-1 p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-md hover:bg-white hover:shadow-lg transition-all">
                                    <svg class="w-4 h-4 text-brand-secondary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-section>
