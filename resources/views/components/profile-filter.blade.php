{{-- resources/views/components/profile-filter.blade.php --}}
<div class="flex flex-col pt-7 sm:pt-0">
    {{-- Navigation links --}}
    <div class="flex flex-col gap-1 mt-2 text-base text-gray-800">
        <a href="{{ route('professional_profile.index') }}" 
           class="hover:text-blue-600 transition">All</a>
        @auth
            <a href="{{ route('professional_profile.index', ['following' => true]) }}" 
               class="hover:text-blue-600 transition">Following</a>
            <a href="{{ route('professional_profile.index', ['followed' => true]) }}" 
               class="hover:text-blue-600 transition">Followers</a>
        @endauth
    </div>
    
    <hr class="bg-gray-300 h-px border-0 my-3">

    {{-- Filter section --}}
    <div>
        <div class="flex flex-row justify-between items-end mt-2">
            <h2 class="text-base text-gray-800 font-medium">Filter</h2>
            <a class="text-base text-gray-400 hover:text-gray-600" 
               href="{{ route('professional_profile.index') }}">
                Reset filters
            </a>
        </div>
        
        <hr class="bg-gray-300 h-px border-0 my-2">
        
        <form method="get" action="{{ route('professional_profile.index') }}">
            {{-- Skills --}}
            <h3 class="text-base text-gray-600 mt-2 mb-1 leading-4">Skills</h3>
            <div class="ml-2">
                <input type="hidden" name="following" value="{{ $following }}">
                <input type="hidden" name="followed" value="{{ $followed }}">
                
                @foreach ($groupedSkills as $categoryName => $skills)
                    <div class="mb-2">
                        <h4 class="text-base text-gray-500 mb-0.5">{{ $categoryName }}</h4>
                        <div class="flex flex-row gap-1 flex-wrap">
                            @foreach ($skills as $skill)
                                <div class="flex justify-center transition duration-150">
                                    <input type="checkbox" 
                                           name="skill[]" 
                                           id="{{ $idPrefix }}-{{ $skill->name }}"
                                           value="{{ $skill->id }}" 
                                           class="hidden peer"
                                           {{ in_array($skill->id, old('skill', $selectedSkills)) ? 'checked' : '' }}>
                                    <label for="{{ $idPrefix }}-{{ $skill->name }}"
                                           class="px-1 rounded-lg border border-gray-400 text-gray-500 text-base py-0.5 cursor-pointer transition duration-150 hover:bg-gray-600 hover:text-white hover:scale-105 peer-checked:bg-gray-600 peer-checked:text-white peer-checked:font-medium">
                                        {{ $skill->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Name --}}
            <div class="mt-2">
                <label for="{{ $idPrefix }}-name" class="text-base text-gray-600 block mb-1">Name</label>
                <x-text-input id="{{ $idPrefix }}-name" 
                              name="name" 
                              placeholder="Name" 
                              value="{{ old('name', $name) }}" 
                              class="text-base leading-4 w-full" />
            </div>

            {{-- Location --}}
            <div class="mt-2">
                <label for="{{ $idPrefix }}-location" class="text-base text-gray-600 block mb-1">Location</label>
                <x-text-input id="{{ $idPrefix }}-location" 
                              name="location" 
                              placeholder="(e.g. London)"
                              value="{{ old('location', $location) }}" 
                              class="text-base leading-4 w-full" />
            </div>

            {{-- Submit button --}}
            <x-primary-button type="submit" class="mt-5 w-full flex justify-center">
                Apply Filter
            </x-primary-button>
        </form>
    </div>
</div>