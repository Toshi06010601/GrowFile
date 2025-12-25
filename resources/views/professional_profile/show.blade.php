<x-app-layout>
    <div class="py-5 flex flex-col-reverse sm:grid sm:grid-cols-8 gap-4 px-5 sm:px-16 max-w-7xl mx-auto">
        {{-- Main: Learning records section --}}
        <div class="col-span-5">
            <div class="hidden sm:block">
                <livewire:Profile.BackgroundSection :profileId="$profile->id" />
            </div>

            <div class="flex flex-col gap-6">

                <livewire:Profile.StudyDashboard :userId="$profile->user_id" />
                
                <livewire:Profile.StudyRecordsChart :userId="$profile->user_id" />
    
            </div>

            @can('update', $profile)
                <livewire:Profile.BackgroundForm />
                <livewire:Profile.StudyRecordForm />
            @endcan
        </div>

        {{-- Side bar: Profile section --}}
        <div class="col-span-3 space-y-2 p-3 bg-white shadow sm:rounded-lg">
            <div class="block sm:hidden">
                <livewire:Profile.BackgroundSection :profileId="$profile->id" />
            </div>

            <livewire:Profile.ProfileSection :profileId="$profile->id" />

            <livewire:Profile.BioSection :profileId="$profile->id" />

            <livewire:Profile.UserSkillsSection :userId="$profile->user_id" />

            <livewire:Profile.ExperiencesSection :userId="$profile->user_id" />

            @can('update', $profile)
                <livewire:Profile.ProfileForm />
                <livewire:Profile.BioForm />
                <livewire:Profile.UserSkillForm />
                <livewire:Profile.ExperienceForm />
            @endcan

        </div>
    </div>
</x-app-layout>
