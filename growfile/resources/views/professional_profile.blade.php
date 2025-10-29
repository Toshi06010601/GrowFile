<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-5 grid grid-cols-3 gap-4 px-4">
        <div class="col-span-2">
            <div class="max-w-2xl">
                <livewire:StudyRecordsSection />
                <livewire:StudyRecordForm />
            </div>
        </div>
        <div class="col-span-1">
            <div class="max-w-xl">
                <livewire:ProfileSection />
            </div>
        </div>
    </div>
</x-app-layout>
