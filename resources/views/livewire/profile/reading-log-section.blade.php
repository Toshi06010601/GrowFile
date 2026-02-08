<x-section class="h-full" id="reading-log-section">
    {{-- Header area --}}
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-brand-secondary-900">
            Reading Logs
        </h2>

        {{-- button to add a new reading log --}}
        @if ($isOwner)
            <x-section.add-icon x-data=""
                x-on:click="
                $dispatch('set-reading-log', { id: null , 
                isOwner: {{ $isOwner ? 'true' : 'false' }} });" />
        @endif
    </x-slot>

    {{-- Reading Log section --}}

    <x-session-flash-message></x-session-flash-message>

    {{-- Display reading logs below --}}
    {{-- Wire:key for ul is to re-render after adding new book --}}
    <ul class="flex flex-row max-w-full overflow-x-auto gap-4 snap-x snap-mandatory"
        x-data="{ 
            scrollToFirst() {
                this.$nextTick(() => {
                    const firstItem = this.$el.querySelector('li');
                    if (firstItem) {
                        firstItem.scrollIntoView({ behavior: 'smooth', inline: 'start', block: 'nearest' });
                    }
                });
            }
        }" 
        @scroll-to-start.window="scrollToFirst()"
        > 
        @foreach ($readingLogs as $log)
            <li wire:key="{{ $log->id }}"
                class="flex-none w-28 sm:w-32 snap-start flex flex-col p-3 pb-8 gap-1 border shadow-md rounded-md bg-white relative">
                
                <div class="flex flex-col gap-2">
                    {{-- Maintain aspect ratio so images don't stretch --}}
                    <div class="aspect-[3/4] w-full overflow-hidden rounded">
                        <img src="{{ $log->cover_url }}" alt="book_cover" class="w-full h-full object-cover">
                    </div>
                    
                    <div class="flex flex-col items-center gap-1">
                        <div
                        class="flex items-center w-full bg-gray-200 mt-2 rounded-full h-2.5 dark:bg-brand-secondary-200 overflow-hidden">
                        <div class="bg-brand-primary-800 h-2.5 rounded-full transition-all duration-500"
                        style="width: {{ ($log->current_page / $log->total_pages) * 100 }}%">
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="text-xs text-gray-500 text-center">
                        {{ round(($log->current_page / $log->total_pages) * 100) }}% complete
                    </span>
                </div>

                {{-- Show Edit icon for the owner --}}
                @if ($isOwner)
                    <div class="absolute bottom-1 right-1 flex justify-end mt-2 min-w-5">
                        <x-section.edit-icon
                            x-on:click="$dispatch('set-reading-log', { 
                            id: {{ $log->id }}, 
                            isOwner: {{ $isOwner ? 'true' : 'false' }} 
                        })" />
                    </div>
                @else
                    <div class="absolute bottom-1 right-1 flex justify-end mt-2 min-w-5">
                        <x-section.expand-icon
                            x-on:click="$dispatch('set-reading-log', { 
                            id: {{ $log->id }}, 
                            isOwner: {{ $isOwner ? 'true' : 'false' }} 
                        })" />
                    </div>
                @endif
            </div>
        </div>
        
    </li>
        @endforeach
    </ul>
</x-section>
