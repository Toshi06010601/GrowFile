<x-app-layout>
    <div class="flex flex-row gap-4 p-5">
        <x-modal name="filter-profiles" :show="false" focusable>
            <div class="flex bg-white rounded-xl py-2 px-5 w-full flex-col">
                <div class="flex flex-col gap-1 mt-2 text-md text-gray-800">
                    <a href={{ route('professional_profile.index') }}>All</a>
                    @auth
                        <a href={{ route('professional_profile.index', ['following' => true]) }}>Following</a>
                        <a href={{ route('professional_profile.index', ['followed' => true]) }}>Followers</a>
                    @endauth
                </div>
                <hr class="bg-black w-54 mb-3">
                <div>
                    <div class="flex flex-row justify-between items-end mt-2">
                        <h2 class="text-md text-gray-800">Filter</h2>
                        <a class="text-sm text-gray-400" href={{ route('professional_profile.index') }}>Reset filters</a>
                    </div>
                    <hr class="bg-black w-54">
                    <form method="get" action={{ route('professional_profile.index') }}>
                        <h3 class="text-sm text-gray-600 mt-2 mb-1 leading-4">Skills</h3>
                        <div class="ml-2">
                            <input type="hidden" name="following" value="{{ $following }}">
                            <input type="hidden" name="followed" value="{{ $followed }}">
                            @foreach ($groupedSkills as $categoryName => $skills)
                                <div class="mb-2">
                                    <h4 class="text-sm text-gray-500 mb-0.5">{{ $categoryName }}</h4>
                                    <div class="flex flex-row gap-1 flex-wrap">
                                        @foreach ($skills as $skill)
                                            <div
                                                class="flex justify-center hover:border-gray-500 transition duration-150">
                                                <input type="checkbox" name="skill[]" id="{{ $skill->name }}"
                                                    value="{{ $skill->id }}" class="hidden peer"
                                                    {{ in_array($skill->id, old('skill', $selectedSkills ?? [])) ? 'checked' : '' }}>
                                                <label for="{{ $skill->name }}"
                                                    class="
                                                    px-1 rounded-lg border border-gray-400
                                                    text-gray-500 text-sm py-0.5 cursor-pointer 
                                                    transition duration-150
                                                    peer-checked:bg-gray-600         {{-- <-- Apply BG color when checked --}}
                                                    peer-checked:text-white          {{-- <-- Change text color when checked --}}
                                                    peer-checked:font-medium
                                                ">{{ $skill->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-2">
                            <label for="name" class="text-sm text-gray-600 block mb-1">Name</label>
                            <x-text-input id="name" name="name" placeholder="Name"
                                value="{{ old('name', $name) }}" class="text-sm leading-4" />
                        </div>
                        <div class="mt-2">
                            <label for="location" class="text-sm text-gray-600 block mb-1">Location</label>
                            <x-text-input id="location" name="location" placeholder="(e.g. London)"
                                value="{{ old('location', $location) }}" class="text-sm leading-4" />
                        </div>
                        <x-primary-button class="mt-5 w-full flex justify-center">
                            Apply Filter
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </x-modal>
        <aside class="hidden sm:flex bg-white rounded-xl py-2 px-5 w-56 flex-col flex-shrink-0">
            <div class="flex flex-col gap-1 mt-2 text-md text-gray-800">
                <a href={{ route('professional_profile.index') }}>All</a>
                @auth
                    <a href={{ route('professional_profile.index', ['following' => true]) }}>Following</a>
                    <a href={{ route('professional_profile.index', ['followed' => true]) }}>Followers</a>
                @endauth
            </div>
            <hr class="bg-black w-54 mb-3">
            <div>
                <div class="flex flex-row justify-between items-end mt-2">
                    <h2 class="text-md text-gray-800">Filter</h2>
                    <a class="text-sm text-gray-400" href={{ route('professional_profile.index') }}>Reset filters</a>
                </div>
                <hr class="bg-black w-54">
                <form method="get" action={{ route('professional_profile.index') }}>
                    <h3 class="text-sm text-gray-600 mt-2 mb-1 leading-4">Skills</h3>
                    <div class="ml-2">
                        <input type="hidden" name="following" value="{{ $following }}">
                        <input type="hidden" name="followed" value="{{ $followed }}">
                        @foreach ($groupedSkills as $categoryName => $skills)
                            <div class="mb-2">
                                <h4 class="text-sm text-gray-500 mb-0.5">{{ $categoryName }}</h4>
                                <div class="flex flex-row gap-1 flex-wrap">
                                    @foreach ($skills as $skill)
                                        <div class="flex justify-center hover:border-gray-500 transition duration-150">
                                            <input type="checkbox" name="skill[]" id="{{ $skill->name }}"
                                                value="{{ $skill->id }}" class="hidden peer"
                                                {{ in_array($skill->id, old('skill', $selectedSkills ?? [])) ? 'checked' : '' }}>
                                            <label for="{{ $skill->name }}"
                                                class="
                                                    px-1 rounded-lg border border-gray-400
                                                    text-gray-500 text-sm py-0.5 cursor-pointer 
                                                    transition duration-150
                                                    peer-checked:bg-gray-600         {{-- <-- Apply BG color when checked --}}
                                                    peer-checked:text-white          {{-- <-- Change text color when checked --}}
                                                    peer-checked:font-medium
                                                ">{{ $skill->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2">
                        <label for="name" class="text-sm text-gray-600 block mb-1">Name</label>
                        <x-text-input id="name" name="name" placeholder="Name" value="{{ old('name', $name) }}"
                            class="text-sm leading-4" />
                    </div>
                    <div class="mt-2">
                        <label for="location" class="text-sm text-gray-600 block mb-1">Location</label>
                        <x-text-input id="location" name="location" placeholder="(e.g. London)"
                            value="{{ old('location', $location) }}" class="text-sm leading-4" />
                    </div>
                    <x-primary-button class="mt-5 w-full flex justify-center">
                        Apply Filter
                    </x-primary-button>
                </form>
            </div>
        </aside>

        <section class="flex-grow bg-white rounded-xl py-5 px-7 md:px-10">
            {{-- Search result --}}
            <div class="flex flex-row justify-between items-center mb-3">
                <h1 class="text-2xl md:text-3xl font-medium">Search Result</h1>
                <button type="button" class="sm:hidden" x-data="" x-on:click="$dispatch('open-modal', 'filter-profiles')">
                    <img src={{ asset('images/icons/filter.svg') }} alt="search-icon"
                        class="w-5 mx-2 cursor-pointer hover:scale-110" />
                </button>
            </div>
            <ul class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                @foreach ($profiles as $profile)
                    <li wire:key="{{ $profile->id }}"
                        class="relative w-full h-64 bg-white border-2 border-gray-300 rounded-md overflow-hidden">
                        <a href="{{ route('professional_profile.show', $profile->slug) }}"
                            class="flex flex-col items-center">
                            {{-- Background image --}}
                            <div class="w-full h-20 overflow-hidden border border-gray-600">
                                <img src="/{{ $profile->background_image_path ? $profile->background_image_path : 'storage/background_photos/default.png' }}"
                                    alt="background image" class="w-full h-full object-cover">
                            </div>
                            {{-- Profile image --}}
                            <div
                                class="absolute top-3 z-10 w-20 h-20 rounded-full overflow-hidden border-2 border-white shadow-md">
                                <img src="/{{ $profile->profile_image_path }}" alt="profile image"
                                    class="w-full h-full object-cover">
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
                                        <livewire:FollowButton :userId="$profile->user_id" :isFollowing="!is_null($profile->user->authFollows)" />
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
