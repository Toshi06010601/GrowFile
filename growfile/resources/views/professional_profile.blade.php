<x-app-layout>
    <div class="py-5 grid grid-cols-8 gap-4 px-16 max-w-7xl mx-auto">
        {{-- Main section --}}
        <div class="col-span-5">
            <livewire:BackgroundSection />
            <livewire:BackgroundForm />

            <livewire:StudyRecordsSection />
            <livewire:StudyRecordForm />
        </div>
        {{-- Side bar --}}
        <div class="col-span-3 space-y-2 p-3 bg-white shadow sm:rounded-lg">
            <livewire:ProfileSection />
            <livewire:ProfileForm />

            <livewire:BioSection />
            <livewire:BioForm />

            <livewire:UserSkillsSection />
            <livewire:UserSkillForm />

            <livewire:ExperiencesSection />
            <livewire:ExperienceForm />
        </div>
    </div>
</x-app-layout>
