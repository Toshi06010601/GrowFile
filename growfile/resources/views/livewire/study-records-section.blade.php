{{-- Study records section --}}
<x-section sectionTitle="Study Records" modalName="edit-study-record">

    {{-- each study record below --}}
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
                    <p><strong class="bg-red">{{ $record->category }}</strong>: {{ $record->activity }}</p>
                    <div class="flex flex-row justify-between">
                        <ul>
                            <li>
                                <x-section.partials.tag>Figma</x-section.partials.tag>
                            </li>
                        </ul>
                        <x-section.partials.edit-icon  @click="$dispatch('set-study-record', { id: {{ $record->id }} })"/>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

</x-section>
