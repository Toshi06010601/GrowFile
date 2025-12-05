<x-app-layout>
    <div class="block sm:flex-1 sm:flex sm:flex-row sm:gap-4 p-5">

        {{--Filter Modal for mobile --}}
        <x-modal name="filter-profiles" :show="false" focusable>
            <div class="flex bg-white rounded-xl py-2 px-5 w-full flex-col">
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
        <aside class="hidden sm:flex bg-white rounded-xl py-2 px-5 w-56 flex-col flex-shrink-0">
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
        <section class="flex-grow bg-white rounded-xl py-5 px-7 md:px-10">
            <div class="flex flex-row justify-between items-center mb-3">
                <h1 class="text-2xl md:text-3xl font-medium">Search Result</h1>
                <button type="button" class="sm:hidden" x-data="" x-on:click="$dispatch('open-modal', 'filter-profiles')">
                    <img src={{ asset('images/icons/filter.svg') }} alt="search-icon"
                        class="w-5 mx-2 cursor-pointer hover:scale-110" />
                </button>
            </div>
            <ul class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach ($profiles as $profile)
                    <li wire:key="{{ $profile->id }}"
                        class="relative w-full h-64 bg-white border-2 border-gray-300 rounded-md overflow-hidden shadow-lg shadow-gray-400 hover:scale-105">
                        <a href="{{ route('professional_profile.show', $profile->slug) }}"
                            class="flex flex-col items-center">
                            {{-- Background image --}}
                            <div class="w-full h-20 overflow-hidden border border-gray-600">
                                <img src="{{ $profile->background_image_path }}"
                                    alt="background image" class="w-full h-full object-cover">
                            </div>
                            {{-- Profile image --}}
                            <div
                                class="absolute top-3 z-10 w-20 h-20 rounded-full overflow-hidden border-2 border-white shadow-md">
                                <img src="{{ $profile->profile_image_path }}" alt="profile image"
                                    class="w-full h-full object-cover bg-white">
                            </div>
                            <div class="flex flex-col gap-0 p-1">
                                {{-- Full name --}}
                                <p class="text-sm text-center mt-9 line-clamp-1">
                                    <strong>{{ $profile->full_name }}</strong>
                                </p>
                                {{-- headline --}}
                                <p class="text-xs md:text-sm text-center text-gray-700 line-clamp-2">
                                    {{ $profile->headline }}</p>
                                {{-- location --}}
                                <p class="text-xs md:text-sm text-center text-gray-600 line-clamp-1">
                                    {{ $profile->location }}</p>
                                {{-- bio --}}
                                <p class="text-xs md:text-sm text-center text-gray-500 line-clamp-3 mt-2">
                                    {{ $profile->bio }}
                                </p>

                                {{-- Follow button --}}
                                @auth
                                    @if (Auth::id() !== $profile->user_id)
                                        <livewire:Profile.Partials.FollowButton :userId="$profile->user_id" :isFollowing="!is_null($profile->user->authFollows)" idPrefix="index" />
                                    @endif
                                @endauth
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="mb-4">
                {{ $profiles->appends(request()->except('page'))->links() }}
            </div>
        </section>
    </div>

</x-app-layout>
