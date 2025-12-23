<x-section class="h-full" id="study-section">
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-gray-900">
            {{ $currentView === 'diary' ? 'Study Diary' : 'Study Records' }}
        </h2>

        {{-- button to add a new record --}}
        @if ($isOwner && $currentView === 'records')
            <x-section.add-icon x-data=""
                x-on:click="
                $dispatch('set-study-record', { id: null });" />
        @endif
    </x-slot>


    <div class="mb-3">
        <div class="{{ $currentView === 'diary' ? 'block' : 'hidden' }}">
            <div wire:ignore>
                @include('components.study-calendar', ['userId' => $userId])
            </div>
        </div>
        <div class="{{ $currentView === 'diary' ? 'hidden' : 'block' }}">
            <livewire:Profile.StudyRecordsSection :userId="$userId" />
        </div>
    </div>

    <nav class="flex flex-row justify-end text-gray-600">
        @if ($currentView === 'diary')
            <button type="button" wire:click="$set('currentView', 'records')"
                onclick="document.getElementById('study-section').scrollIntoView({ behavior: 'smooth' })"
                class="flex flex-row gap-2">Records <img src="{{ asset('images/icons/right-arrow.svg') }}"
                    alt="right-arrow" class="w-4"></button>
        @else
            <button type="button" wire:click="$set('currentView', 'diary')"
                onclick="document.getElementById('study-section').scrollIntoView({ behavior: 'smooth' })"
                class="flex flex-row gap-2"><img src="{{ asset('images/icons/left-arrow.svg') }}" alt="right-arrow"
                    class="w-4">Diary</button>
        @endif
    </nav>

</x-section>
