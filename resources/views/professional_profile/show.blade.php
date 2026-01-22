<x-app-layout>
    <div class="py-5 flex flex-col-reverse md:grid md:grid-cols-8 gap-4 px-5 sm:px-16 w-full max-w-7xl mx-auto">
        {{-- Main: Learning records section --}}
        <div class="col-span-5">
            <div class="hidden md:block">
                <livewire:Profile.BackgroundSection :profileId="$profile->id" key="background-desktop" />
            </div>

            <div class="w-full flex flex-col gap-6">

                <livewire:Profile.StudyDashboard :userId="$profile->user_id" />

                <livewire:Profile.StudyRecordsChart :userId="$profile->user_id" />

                <livewire:Profile.ReadingLogSection :userId="$profile->user_id" />

                <livewire:Profile.CourseSection :userId="$profile->user_id" />

                <livewire:Profile.ArticleSection :userId="$profile->user_id" />

                <livewire:Profile.PortfolioSection :userId="$profile->user_id" />

            </div>

            @can('update', $profile)
                <livewire:Profile.BackgroundForm />
                <livewire:Profile.StudyRecordForm />
            @endcan

            <livewire:Profile.ReadingLogForm />
            <livewire:Profile.PortfolioForm />
            <livewire:Profile.ArticleForm />
            <livewire:Profile.CourseForm />
        </div>

        {{-- Side bar: Profile section --}}
        <div class="col-span-3 space-y-2 p-3 bg-white shadow sm:rounded-lg">
            <div class="block md:hidden">
                <livewire:Profile.BackgroundSection :profileId="$profile->id" key="background-mobile" />
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
