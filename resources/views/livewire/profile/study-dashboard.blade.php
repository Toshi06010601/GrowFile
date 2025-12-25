<x-section class="h-full" id="study-section">
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-brand-secondary-900">
            {{ $currentView === 'diary' ? 'Study Diary' : 'Study Records' }}
        </h2>

        {{-- button to add a new record --}}
        @if ($isOwner && $currentView === 'records')
            <x-section.add-icon x-data=""
                x-on:click="
                $dispatch('set-study-record', { id: null });" />
        @endif
    </x-slot>


    <div class="mb-3" x-data="{ view: @entangle('currentView') }"
        x-effect="if(view === 'diary') { setTimeout(() => window.calendar.updateSize(), 100) }">
        <div :class="view === 'diary' ? 'block' : 'hidden'" wire:ignore>
            @include('components.section.study-calendar', ['userId' => $userId])
        </div>
        <div :class="view === 'diary' ? 'hidden' : 'block'">
            <livewire:Profile.StudyRecordsSection :userId="$userId" />
        </div>
    </div>

    <nav class="flex flex-row justify-end text-base sm:text-xl font-normal cursor-pointer">
        @if ($currentView === 'diary')
            <button type="button" wire:click="$set('currentView', 'records')"
                onclick="document.getElementById('study-section').scrollIntoView({ behavior: 'smooth', block: 'start'})"
                class="flex flex-row gap-2 text-brand-secondary-600 hover:text-brand-secondary-400">Records <img src="{{ asset('images/icons/right-arrow.svg') }}"
                    alt="right-arrow" class="w-4"></button>
        @else
            <button type="button" wire:click="$set('currentView', 'diary')"
                onclick="document.getElementById('study-section').scrollIntoView({ behavior: 'smooth', block: 'start' })"
                class="flex flex-row gap-2 text-brand-secondary-600 hover:text-brand-secondary-400"><img src="{{ asset('images/icons/left-arrow.svg') }}" alt="right-arrow"
                    class="w-4">Diary</button>
        @endif
    </nav>

</x-section>
