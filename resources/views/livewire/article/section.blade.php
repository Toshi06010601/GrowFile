<x-section id="article-section">
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-brand-secondary-900">
            {{ __('professional-profile.published-articles') }}
        </h2>
        @if ($isOwner)
            <x-section.add-icon x-data=""
                x-on:click.stop="$dispatch('set-article', { id: null });" />
        @endif
    </x-slot>

    @if ($hasError)
        <x-loading-error>{{ __('professional-profile.failed-to-load-articles') }}</x-loading-error>
    @endif

    @if (!$hasError)
        @if (count($this->articles) > 0)
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
                        @foreach ($this->articles as $article)
                            <li class="splide__slide py-1 h-full" wire:key="article-slide-{{ $article->id }}">
                                <div
                                    class="relative slider-content h-full flex items-center bg-white rounded-md shadow-md overflow-hidden border border-brand-secondary-100 transition hover:shadow-lg">
                                    <div class="flex-1 pl-3 py-2 flex flex-col">
                                        <p class="text-brand-secondary-500 text-xs line-clamp-1">
                                            {{ __('professional-profile.published-in') }} {{ $article->platform_name }}
                                        </p>
                                        <p class="text-base font-semibold text-brand-secondary-900 line-clamp-1">
                                            <a href="{{ $article->article_url }}" target="blank">
                                                {{ $article->title }}
                                            </a>
                                        </p>
                                        <p class="text-brand-secondary-600 text-sm flex-1 line-clamp-2">
                                            {{ $article->description }}
                                        </p>
                                        <div class="flex justify-end">
                                            <p class="text-brand-secondary-500 text-xs line-clamp-1">
                                                {{ __('professional-profile.published-at') }} {{ $article->published_date->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 p-2 sm:p-3">
                                        <div class="w-32 sm:w-40 aspect-video overflow-hidden rounded-md bg-gray-100">
                                            <img src="{{ $article->article_image_path !== '' ? asset("storage/{$article->article_image_path}") : '/storage/article_photos/default.jpg' }}"
                                                alt="{{ $article->title }}" class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                    @if ($isOwner)
                                        <x-section.edit-icon x-data=""
                                            x-on:click.stop="$dispatch('set-article', { id: {{ $article->id }} })"
                                            class="absolute bottom-1 right-1" />
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <x-no-data-to-display fileName="article.svg">{{ __('professional-profile.no-articles') }}</x-no-data-to-display>
        @endif
    @endif
</x-section>
