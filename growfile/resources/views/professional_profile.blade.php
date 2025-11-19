<x-app-layout>
    <div class="py-5 grid grid-cols-8 gap-4 px-16 max-w-7xl mx-auto">
        {{-- Main section --}}
        <div class="col-span-5">
            <livewire:BackgroundSection :profileId="$profile->id"/>

            <livewire:StudyRecordsSection :userId="$profile->user_id"/>

            @can('update', $profile)
                <livewire:BackgroundForm />
                <livewire:StudyRecordForm />
            @endcan
        </div>
        {{-- Side bar --}}
        <div class="col-span-3 space-y-2 p-3 bg-white shadow sm:rounded-lg">

            <livewire:ProfileSection :profileId="$profile->id" />

            <livewire:BioSection :profileId="$profile->id" />

            <livewire:UserSkillsSection :userId="$profile->user_id" />

            <livewire:ExperiencesSection :userId="$profile->user_id" />

            @can('update', $profile)
                <livewire:ProfileForm />
                <livewire:BioForm />
                <livewire:UserSkillForm />
                <livewire:ExperienceForm />
            @endcan

        </div>
    </div>
</x-app-layout>
