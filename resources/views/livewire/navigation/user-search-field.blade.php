<div class="w-full md:w-96" x-data="{ open: false }" @click.away="open = false">
    {{-- Search field --}}
    <form method="get" action={{ route('professional_profile.index') }}
        class="flex flex-row border-gray-300 border-2 rounded-md shadow-sm">
        {{-- Search icon --}}
        <button wire:click="submit">
            <img src={{ asset('images/icons/search.svg') }} alt="search-icon"
                class="w-5 mx-2 cursor-pointer hover:scale-110" />
        </button>
        {{-- Search input field --}}
        <div class="flex-1">
            <input type="text" name="name"
                class="w-full py-2 px-0 border-none rounded-lg focus:border-none focus:ring-0 focus:outline-none"
                placeholder="Search Users" wire:model.live="search" x-on:focus="open = true"
                x-on:keydown.escape.prevent="open = false" autocomplete="off" />
        </div>
        {{-- Erase button --}}
        <button type="button" wire:click="$set('search', '')" >
            <img src={{ asset('images/icons/close.svg') }} alt="erase-icon" class="w-3 mx-2 cursor-pointer hover:scale-110"
               />
        </button>
    </form>

    {{-- Show suggestions that matches the search word --}}
    <div class="relative">
        <ul x-show="open" x-transition class="absolute top-0 left-0 z-20 w-full bg-white border-gray-300 rounded-md"
            :class="open ? 'border-x-2 border-b-2 border-gray-300 shadow-md' :
                'border border-transparent'">
            {{-- Suggestions --}}
            @foreach ($suggestions as $suggestion)
                <li wire:key={{ $suggestion->id }} class="relative first:mt-1  mb-1 pb-1 px-1 border-b border-dashed">
                    <a href={{ route('professional_profile.show', $suggestion->slug) }}
                        class="flex flex-row justify-start items-center gap-3">
                        <div class="ml-1 size-5 md:size-7 rounded-full overflow-hidden border">
                            <img src="{{ $suggestion->profile_image_path }}" alt="profile image"
                                class="w-full h-full object-cover">
                        </div>
                        <p class="text-gray-700 text-wrap text-base md:text-base">{{ $suggestion->full_name }}</p>
                        <p class="text-gray-500 text-wrap text-xs md:text-base">{{ $suggestion->headline }}</p>
                    </a>
                </li>
            @endforeach

            {{-- View all results option --}}
            @if (!empty($suggestions))
                <li class="relative first:mt-1 mb-1 py-1 border-b-0 border-dashed">
                    <a href="{{ route('professional_profile.index', ['name' => $search]) }}"
                        class="flex flex-row justify-start items-center ml-3">
                        <p class="text-blue-700 text-base md:text-base">View Search Results</p>
                    </a>
                </li>
            @else
                <li class="relative first:mt-1 mb-1 py-1 border-b-0 border-dashed">
                    <a href="{{ route('professional_profile.index') }}"
                        class="flex flex-row justify-start items-center ml-3">
                        <p class="text-blue-700 text-base md:text-base">View All Profiles</p>
                    </a>
                </li>
            @endif

        </ul>
    </div>
</div>
