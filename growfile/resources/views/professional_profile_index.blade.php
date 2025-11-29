<x-app-layout>
    <div class="flex flex-row gap-4 p-5">
        <aside class="bg-white rounded-xl py-2 px-5 w-56 flex flex-col flex-shrink-0">
            <div class="flex flex-col gap-1 my-2 text-md text-gray-600">
                <a href={{ route('professional_profile.index') }}>All</a>
                <a href={{ route('professional_profile.index') }}>Following</a>
                <a href={{ route('professional_profile.index') }}>Followers</a>
            </div>
            <hr class="bg-black w-54">
            <div>
                <div class="flex flex-row justify-between items-end mt-2">
                    <h2 class="text-md text-gray-600">Filter</h2>
                    <a class="text-sm text-gray-400" href={{ route('professional_profile.index') }}>Reset filters</a>
                </div>
                <hr class="bg-black w-54">
                <form method="get" action="{{ route('professional_profile.index') }}">
                    <h3 class="text-md text-gray-600 my-2 leading-4">Skills</h3>
                    <div class="ml-1">
                        @foreach ($groupedSkills as $categoryName => $skills)
                            <h4 class="text-md text-gray-500 mb-1">{{ $categoryName }}</h4>
                            <div class="flex flex-row gap-1 flex-wrap">
                                @foreach ($skills as $skill)
                                    <div class="flex justify-center hover:border-gray-500 transition duration-150">
                                        <input type="checkbox" name="skill[]" id="{{ $skill->name }}"
                                            value="{{ $skill->id }}" class="hidden peer"
                                            {{ in_array($skill->id, old('skill', $selectedSkills ?? [])) ? 'checked' : '' }}>
                                        <label
                                            for="{{ $skill->name }}"
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
                        @endforeach
                    </div>
                    <div class="mt-2">
                        <x-input-label value="Name" for="name" />
                        <x-text-input id="name" name="name" placeholder="Name"
                            value="{{ old('name', $name) }}" />
                    </div>
                    <div class="mt-2">
                        <x-input-label value="Location" for="location" />
                        <x-text-input id="location" name="location" placeholder="(e.g. London)"
                            value="{{ old('location', $location) }}" />
                    </div>
                    <x-primary-button class="mt-5 w-full flex justify-center">
                        Apply Filter
                    </x-primary-button>
                </form>
            </div>
        </aside>

        <section class="flex-grow bg-white rounded-xl py-5 px-7 md:px-10">
            {{-- Search result --}}
            <h1 class="text-2xl md:text-3xl font-medium mb-3">Search Result</h1>
            <ul class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach ($profiles as $profile)
                    <li wire:key="{{ $profile->id }}"
                        class="relative w-full h-56 sm:h-64 bg-white border-2 border-gray-300 rounded-md overflow-hidden">
                        <a href="{{ route('professional_profile.show', $profile->slug) }}"
                            class="flex flex-col items-center">
                            {{-- Background image --}}
                            <div class="w-full h-14 overflow-hidden border border-gray-600">
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
