<div class="w-full md:w-96" x-data="{ open: false }" @click.away="open = false">
    {{-- Search field --}}
    <x-text-input type="text" class="w-full" placeholder="Search Users" wire:model.live="search" x-on:focus="open = true" 
        x-on:keydown.escape.prevent="open = false" />

    {{-- Show suggestions that matches the search word --}}
    <div class="relative">
        <ul x-show="open" x-transition class="absolute top-0 left-0 z-20 w-full bg-white border-gray-300 rounded-md"
            :class="($wire.suggestions?.length ?? 0) > 0 ? 'border-x-2 border-b-2 border-gray-300 shadow-md' :
                'border border-transparent'">
            @foreach ($suggestions as $suggestion)
                <li wire:key={{ $suggestion->id }} class="relative first:mt-1  mb-1 pb-1 px-1 border-b border-dashed">
                    <a href={{ route('professional_profile.show', $suggestion->slug) }} class="flex flex-row justify-start items-center gap-3">
                        <div class="ml-1 size-5 md:size-7 rounded-full overflow-hidden border">
                            <img src="/{{ $suggestion->profile_image_path }}" alt="profile image"
                                class="w-full h-full object-cover">
                        </div>
                        <p class="text-gray-700 text-wrap text-sm md:text-md">{{ $suggestion->full_name }}</p>
                        <p class="text-gray-500 text-wrap text-xs md:text-sm">{{ $suggestion->headline }}</p>
                    </a>
                </li>
            @endforeach

            {{-- View all results option --}}
            @if(!empty($suggestions))
                <li class="relative first:mt-1 mb-1 pb-1 border-b-0 border-dashed">
                    <a href="{{ route('professional_profile.index') }}?name={{ urlencode($search) }}" class="flex flex-row justify-start items-center ml-3">
                        <p class="text-blue-700 text-sm md:text-md">View All Results</p>
                    </a>
                </li>
            @else
                <li class="relative first:mt-1 mb-1 pb-1 border-b-0 border-dashed">
                    <a href="{{ route('professional_profile.index') }}" class="flex flex-row justify-start items-center ml-3">
                        <p class="text-blue-700 text-sm md:text-md">View All Profiles</p>
                    </a>
                </li>
            @endif

        </ul>
    </div>
</div>
