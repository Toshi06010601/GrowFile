<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-5 grid grid-cols-8 gap-4 px-16 max-w-7xl mx-auto">
        <div class="col-span-5">
            <livewire:StudyRecordsSection />
            <livewire:StudyRecordForm />
        </div>
        <div class="col-span-3 space-y-2 p-3 bg-white shadow sm:rounded-lg">
            <livewire:ProfileSection />
            <livewire:ProfileForm />
        </div>
    </div>
</x-app-layout>
