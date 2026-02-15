<div class="w-full md:w-96"   
    {{-- Start: Attributes for dropdown-navigator.js --}}
        x-data="{
            open: false,
            ...dropdownNavigator()
            }" 
        @keydown.down.prevent="navigateDown()" 
        @keydown.up.prevent="navigateUp()"
        @keydown.enter.prevent="selectCurrent()" 
        @keydown.escape="reset()" 
    {{-- Start: Attributes for dropdown-navigator.js --}}
    @click.away="open = false">
    {{-- Search field --}}
    <form method="get" action={{ route('professional_profile.index') }}
        class="flex flex-row border-brand-secondary-300 bg-white border-2 rounded-md shadow-sm">
        {{-- Search icon --}}
        <button wire:click="submit">
            <img src={{ asset('images/icons/search.svg') }} alt="search-icon"
                class="w-5 mx-2 cursor-pointer hover:scale-110" />
        </button>
        {{-- Search input field --}}
        <div class="flex-1 relative flex items-center">
            <input type="text" name="name"
                class="w-full py-2 px-0 border-none rounded-lg focus:border-none focus:ring-0 focus:outline-none"
                placeholder="Search Users"
                wire:model.live.debounce.200="search"
                {{-- Identify the input so Alpine can target it --}}
                x-ref="searchInput"
                
                {{-- Listen for Meta (Cmd) + K or Control + K --}}
                x-on:keydown.window.meta.k.prevent="$refs.searchInput.focus()"
                x-on:keydown.window.ctrl.k.prevent="$refs.searchInput.focus()"

                x-on:focus="open = true"
                x-on:input="open = true"
                x-on:keydown.escape.prevent="open = false"
                autocomplete="off" />

            <div class="absolute right-0 flex items-center pr-2 pointer-events-none" x-show="!open">
                <kbd class="sm:flex items-center gap-0.5 px-1.5 py-0.5 text-[10px] font-sans font-semibold text-gray-400 bg-gray-50 border border-gray-200 rounded-md">
                    <span class="text-xs">⌘</span>K
                </kbd>
            </div>
        </div>

        {{-- Erase button --}}
        <button type="button" wire:click="$set('search', '')" >
            <img src={{ asset('images/icons/close.svg') }} alt="erase-icon" class="w-3 mx-2 cursor-pointer hover:scale-110"
               />
        </button>
    </form>

    {{-- Show suggestions that matches the search word --}}
    <div class="relative">
        <ul x-show="open" x-transition class="absolute top-0 left-0 z-20 w-full bg-white border-brand-secondary-300 rounded-md"
            :class="open ? 'border-x-2 border-b-2 border-brand-secondary-300 shadow-md' :
                'border border-transparent'">
            {{-- Suggestions --}}
            @foreach ($suggestions as $index => $suggestion)
                <li wire:key={{ $suggestion->id }} 
                    {{-- Start: Attributes for dropdown-navigator.js --}}
                        data-suggestion-item
                        @click="open = false; reset();"
                        :class="isSelected({{ $index }}) ? 'bg-brand-secondary-50' : ''"
                    {{-- End: Attributes for dropdown-navigator.js --}}
                    class="relative first:pt-1 pb-2 px-1 border-b border-dashed hover:bg-brand-secondary-50">
                    <a href={{ route('professional_profile.show', $suggestion->slug) }}
                        wire:navigate.hover
                        class="flex flex-row justify-start items-center gap-3">
                        <div class="ml-1 size-5 md:size-7 rounded-full overflow-hidden border">
                            <img src="{{ asset("/storage/{$suggestion->profile_image_path}") }}" alt="profile image"
                                class="w-full h-full object-cover">
                        </div>
                        <p class="text-brand-secondary-700 text-wrap text-base md:text-base">{{ $suggestion->full_name }}</p>
                        <p class="text-brand-secondary-500 text-wrap text-xs md:text-base">{{ $suggestion->headline }}</p>
                    </a>
                </li>
            @endforeach

            {{-- View all results option --}}
            @if (!empty($suggestions))
                <li class="relative first:mt-1 mb-1 py-1 border-b-0 border-dashed hover:bg-brand-secondary-50"
                 {{-- Start: Attributes for dropdown-navigator.js --}}
                    data-suggestion-item
                    @click="open = false; reset();"
                    :class="isSelected({{ count($suggestions) }}) ? 'bg-brand-secondary-50' : ''"
                {{-- End: Attributes for dropdown-navigator.js --}}>
                    <a href="{{ route('professional_profile.index', ['name' => $search]) }}"
                        wire:navigate.hover
                        class="flex flex-row justify-start items-center ml-3">
                        <p class="text-blue-700 text-base md:text-base">View Search Results</p>
                    </a>
                </li>
            @else
                <li class="relative first:mt-1 mb-1 py-1 border-b-0 border-dashed hover:bg-brand-secondary-50"
                  {{-- Start: Attributes for dropdown-navigator.js --}}
                    data-suggestion-item
                    @click="open = false; reset();"
                    :class="isSelected({{ count($suggestions) }}) ? 'bg-brand-secondary-50' : ''"
                {{-- End: Attributes for dropdown-navigator.js --}}>
                    <a href="{{ route('professional_profile.index') }}"
                        wire:navigate.hover
                        class="flex flex-row justify-start items-center ml-3">
                        <p class="text-blue-700 text-base md:text-base">View All Profiles</p>
                    </a>
                </li>
            @endif

        </ul>
    </div>
</div>
