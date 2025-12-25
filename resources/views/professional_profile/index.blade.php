<x-app-layout>
    <div class="flex flex-col flex-1 sm:flex-row sm:gap-4 p-5">

        {{--Filter Modal for mobile --}}
        <x-modal name="filter-profiles" :show="false" focusable>
            <div class="flex bg-brand-tertiary-50 rounded-xl py-2 px-5 w-full flex-col">
                <x-modal.icon-close />
                {{-- Reusable filter component --}}
                <x-profile-filter 
                    :groupedSkills="$groupedSkills"
                    :selectedSkills="$selectedSkills ?? []"
                    :name="$name ?? ''"
                    :location="$location ?? ''"
                    :following="$following ?? false"
                    :followed="$followed ?? false"
                    idPrefix="modal" />
            </div>
        </x-modal>

        {{-- Filter Side bar for laptop --}}
        <aside class="hidden sm:flex bg-brand-tertiary-50 rounded-xl py-2 px-5 w-56 flex-col flex-shrink-0">
               <x-profile-filter 
                    :groupedSkills="$groupedSkills"
                    :selectedSkills="$selectedSkills ?? []"
                    :name="$name ?? ''"
                    :location="$location ?? ''"
                    :following="$following ?? false"
                    :followed="$followed ?? false"
                    idPrefix="sidebar" />
        </aside>

        {{-- Search result --}}
        <section class="flex-grow bg-brand-tertiary-50 rounded-xl py-5  px-3 sm:px-5 md:px-10">
            <div class="flex flex-row justify-between items-center mb-3">
                <h1 class="text-2xl md:text-3xl font-medium">Search Result</h1>
                <button type="button" class="sm:hidden" x-data="" x-on:click="$dispatch('open-modal', 'filter-profiles')">
                    <img src={{ asset('images/icons/filter.svg') }} alt="search-icon"
                        class="w-5 mx-2 cursor-pointer hover:scale-110" />
                </button>
            </div>
            <ul class="flex flex-row justify-start flex-wrap gap-2 sm:gap-4">
                @foreach ($profiles as $profile)
                    <li wire:key="{{ $profile->id }}"
                        class="relative flex flex-col justify-between pb-3 w-36 h-72 sm:w-56 sm:h-80 bg-brand-tertiary-50 border-2 border-brand-secondary-300 rounded-md overflow-hidden shadow-lg shadow-brand-secondary-400 hover:scale-105">
                        <a href="{{ route('professional_profile.show', $profile->slug) }}"
                            class="h-full flex flex-col items-center">
                            {{-- Background image --}}
                            <div class="w-full h-20 overflow-hidden border border-brand-secondary-600">
                                <img src="{{ $profile->background_image_path }}"
                                    alt="background image" class="w-full h-full object-cover">
                            </div>
                            {{-- Profile image --}}
                            <div
                                class="absolute top-3 z-10 w-20 h-20 rounded-full overflow-hidden border-2 border-white shadow-md">
                                <img src="{{ $profile->profile_image_path }}" alt="profile image"
                                    class="w-full h-full object-cover bg-brand-tertiary-50">
                            </div>
                            <div class="flex-1 flex flex-col justify-start p-1">
                                {{-- Full name --}}
                                <p class="text-base text-brand-secondary-900 text-center mt-4 line-clamp-1">
                                    <strong>{{ $profile->full_name }}</strong>
                                </p>
                                {{-- headline --}}
                                <p class="text-base md:text-base text-center text-brand-secondary-600 line-clamp-1">
                                    {{ $profile->headline }}</p>
                                {{-- location --}}
                                <p class="text-base md:text-base text-center text-brand-secondary-600 line-clamp-1">
                                    {{ $profile->location }}</p>
                                {{-- bio --}}
                                <p class="text-base md:text-base text-center text-brand-secondary-500 line-clamp-3 mt-2">
                                    {{ $profile->bio }}
                                </p>

                            </div>
                        </a>
                        {{-- Follow button --}}
                        @auth
                            @if (Auth::id() !== $profile->user_id)
                            <div>
                                <livewire:Profile.Partials.FollowButton :userId="$profile->user_id" :isFollowing="!is_null($profile->user->authFollows)" idPrefix="index" wire:key="follow-{{ $profile->id }}" />
                            </div>
                            @endif
                        @endauth
                    </li>
                @endforeach
            </ul>
            <div class="my-4 sm:pr-24">
                {{ $profiles->appends(request()->except('page'))->links() }}
            </div>
        </section>
    </div>

</x-app-layout>
