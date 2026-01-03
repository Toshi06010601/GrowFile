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

    {{-- Reading Log section --}}

    {{-- Display reading logs below --}}
    <ul class="flex flex-row max-w-full overflow-x-auto gap-4 snap-x snap-mandatory">
        @foreach ($readingLogs as $log)
            <li wire:key="{{ $log->id }}"
                class="flex-none w-24 sm:w-32 snap-start flex flex-col p-3 gap-1 border shadow-md rounded-md bg-white">

                <div class="flex flex-col gap-2">
                    {{-- Maintain aspect ratio so images don't stretch --}}
                    <div class="aspect-[3/4] w-full overflow-hidden rounded">
                        <img src="{{ $log->cover_url }}" alt="book_cover" class="w-full h-full object-cover">
                    </div>

                    <div class="min-h-[3rem] flex flex-col justify-between">
                        <p class="text-center text-sm sm:text-base font-medium line-clamp-2">
                            {{ $log->status }}
                        </p>

                        {{-- Show Edit icon for the owner --}}
                        @if ($isOwner)
                            <div class="flex justify-center mt-2">
                                <x-section.edit-icon
                                    x-on:click="$dispatch('set-reading-log', { id: {{ $log->id }} })" />
                            </div>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</x-section>
