{{-- Study records section --}}
<x-section.layout sectionTitle="Study Records" modalName="edit-study-record">

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
                    <p>{{ $record->title }}</p>
                    <div class="flex flex-row justify-between">
                        <ul>
                            <li>
                                <x-section.partials.tag>Figma</x-section.partials.tag>
                            </li>
                        </ul>
                        <x-section.partials.edit-icon :wireAction="'setStudyRecord(' . $record . ')'" />
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    {{-- modal  --}}
    <x-modal name="edit-study-record" :show="$errors->userDeletion->isNotEmpty()" focusable>

        {{-- below are html specifically for learning record modal --}}
        <x-modal.partials.icon-close />

        <form wire:submit="{{ $studyRecord ? "update" : "save" }}" class="px-6 pt-14 pb-6">

            <x-modal.partials.header-title>
                Edit study record
            </x-modal.partials.header-title>

            <x-modal.partials.input-text label="Project Name" id="project-name" name="title"
                placeholder="Project Name" />

            <x-modal.partials.input-text label="Description" id="description" name="description"
                placeholder="What have you worked on?" />

            <x-modal.partials.input-datetime label="Start DateTime" id="start-datetime" name="start_datetime" />

            <x-modal.partials.input-datetime label="End DateTime" id="end-datetime" name="end_datetime" />

            <x-modal.partials.submit-buttons :name="$studyRecord ? 'update' : 'save'"/>
        </form>

    </x-modal>

</x-section.layout>
