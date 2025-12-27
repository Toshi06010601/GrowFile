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
    <ul class="flex flex-row max-h-64 max-w-full gap-5 sm:pr-5 overflow-x-scroll text-base sm:text-xl">
        @foreach ($readingLogs as $log)
            <li wire:key="{{ $log->id }}" class="flex flex-col p-3 gap-1 border shadow-md rounded-md">
                <div class="flex flex-col gap-1">
                    {{-- Display cover image --}}
                    <div>
                        <img src="{{ $log->cover_url }}" alt="book_cover">
                    </div>
                    <div>
                        <p class="text-center">{{ $log->status }}</p>
                    </div>
                    {{-- Show Edit icon for the owner --}}
                    @if ($isOwner)
                        <x-section.edit-icon x-on:click="$dispatch('set-reading-log', { id: {{ $log->id }} })" />
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</x-section>
