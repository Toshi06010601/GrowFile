<x-section class="h-full" id="study-section">
    {{-- Header area --}}
    <x-slot name="header">
        {{-- Change header title depending on current view --}}
        <h2 class="text-xl sm:text-2xl font-medium text-brand-secondary-900">
            {{ $currentView === 'diary' ? 'Study Diary' : 'Study Records' }}
        </h2>

        {{-- button to add a new record in Study Records view --}}
        @if ($isOwner && $currentView === 'records')
            <x-section.add-icon x-data=""
                x-on:click="
                $dispatch('set-study-record', { id: null });" />
        @endif
    </x-slot>

    {{-- Display study calendar or study records (*Use AlpineJS entangle for currentView to not interfere with fullCalendarJS)--}}
    <div class="mb-3" x-data="{ view: @entangle('currentView') }"
        x-effect="if(view === 'diary') { setTimeout(() =>  $dispatch('calendar-update-size'), 100) }">

        {{-- study calendar --}}
        <div :class="view === 'diary' ? 'block' : 'hidden'" wire:ignore>
            @include('components.section.study-calendar', ['userId' => $userId])
        </div>

        {{-- study records --}}
        <div :class="view === 'diary' ? 'hidden' : 'block'">
            <livewire:study-record.study-record-section :userId="$userId" />
        </div>
    </div>

    {{-- view change buttons --}}
    <nav class="flex flex-row justify-end text-base sm:text-xl font-normal cursor-pointer">
        @if ($currentView === 'diary')
            <x-section.view-change-button viewType='records' iconName='right-arrow.svg'>Records</x-section.view-change-button>
        @else
            <x-section.view-change-button viewType='diary' iconName='left-arrow.svg'>Diary</x-section.view-change-button>
        @endif
    </nav>

</x-section>
