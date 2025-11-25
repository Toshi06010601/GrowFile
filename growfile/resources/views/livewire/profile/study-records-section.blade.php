{{-- Study records section --}}
<x-section>

    <x-slot name="header">
        <h2 class="text-2xl font-medium text-gray-900">
            Study Records
        </h2>

        {{-- button to add a new record --}}
        @if ($isOwner)
            <x-section.add-icon x-data=""
                x-on:click="
                $dispatch('set-study-record', { id: null });" />
        @endif
    </x-slot>

    {{-- Display study records below --}}
    <ul class="flex flex-col max-h-96 pr-5 overflow-y-scroll">
        @foreach ($records as $record)
            <li wire:key="{{ $record->id }}" class="flex flex-col p-3 gap-1 border shadow-md rounded-md">
                <div class="flex justify-between">
                    <h2>
                        {{-- Display study date --}}
                        {{ $record->start_datetime->isToday() ? 'Today' : $record->start_datetime->toDateString() }}
                    </h2>
                    <h2>
                        {{-- Display study hours --}}
                        {{ round($record->start_datetime->diffInHours($record->end_datetime), 1) }} hrs
                    </h2>
                </div>

                <hr class="h-0.5 border-none bg-gray-500">

                <div class="flex flex-col gap-1">
                    {{-- Display category and activity --}}
                    <p><strong class="underline">{{ $record->category }}</strong>: {{ $record->activity }}</p>

                    <div class="flex flex-row justify-between">
                        {{-- Display all tags --}}
                        <ul class="max-x-96 overflow-x-scroll flex flex-row justify-start gap-1">
                            @foreach ($record->tags as $tag)
                                <li wire:key="{{ $tag->id }}">
                                    <x-section.tag>{{ $tag->name }}</x-section.tag>
                                </li>
                            @endforeach
                        </ul>
                        
                        {{-- Show Edit icon for the owner --}}
                        @if ($isOwner)
                            <x-section.edit-icon
                                x-on:click="$dispatch('set-study-record', { id: {{ $record->id }} })" />
                        @endif
                    </div>
                </div>
            </li>
        @endforeach

        {{-- Load More Button --}}
        @if ($records->hasMorePages())
            <div class="flex justify-center py-8">
                <button wire:click="loadMore"
                    class="bg-green-900 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                    Load More
                </button>
            </div>
        @endif
    </ul>

</x-section>
