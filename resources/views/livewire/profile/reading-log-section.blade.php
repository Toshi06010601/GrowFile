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
                $dispatch('set-reading-log', { id: null });" />
        @endif
    </x-slot>

    {{-- Error State --}}
    @if ($hasError)
        <x-loading-error>Failed to load articles. Please try again.</x-loading-error>
    @endif

    {{-- Reading Log section --}}
    @if (!$hasError)
        {{-- Display if reading log data exists --}}
        @if (count($this->readingLogs) > 0)

            {{-- Wire:key for ul is to re-render after adding new book --}}
            <ul class="flex flex-row max-w-full overflow-x-auto gap-4 snap-x snap-mandatory" x-data="{
                scrollToFirst() {
                    this.$nextTick(() => {
                        // If already at position 0, scroll slightly right first
                        if (this.$el.scrollLeft === 0) {
                            this.$el.scrollLeft = 1;
                        }
            
                        // Then scroll back to 0
                        setTimeout(() => {
                            this.$el.scrollTo({
                                left: 0,
                                behavior: 'smooth'
                            });
                        }, 50);
                    });
                }
            }"
                @scroll-to-start.window="scrollToFirst()">
                @foreach ($this->readingLogs as $log)
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
                            id: {{ $log->id }}
                        })" />
                                    </div>
                                @else
                                    <div class="absolute bottom-1 right-1 flex justify-end mt-2 min-w-5">
                                        <x-section.expand-icon
                                            x-on:click="$dispatch('set-reading-log', { 
                            id: {{ $log->id }} }} 
                        })" />
                                    </div>
                                @endif
                            </div>
                        </div>

                    </li>
                @endforeach
            </ul>
        @else
            {{-- Display if no reading log exists --}}
            <x-no-data-to-display fileName="book.svg">No reading logs to display</x-no-data-to-display>
        @endif
    @endif
</x-section>
