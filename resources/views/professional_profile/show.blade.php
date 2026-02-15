<x-app-layout>
    <div class="py-5 flex flex-col-reverse md:grid md:grid-cols-8 gap-4 px-5 sm:px-16 w-full max-w-7xl mx-auto">
        {{-- Main: Learning records section --}}
        <div class="col-span-5">
            <div class="hidden md:block">
                <livewire:profile.background-section :userId="$profile->user_id" key="background-desktop" />
            </div>

            <div class="w-full flex flex-col gap-6">
                <livewire:profile.study-dashboard :userId="$profile->user_id" />
                <livewire:profile.study-records-chart :userId="$profile->user_id" />
                <livewire:profile.reading-log-section :userId="$profile->user_id" />
                <livewire:profile.course-section :userId="$profile->user_id" />
                <livewire:profile.article-section :userId="$profile->user_id" />
                <livewire:profile.portfolio-section :userId="$profile->user_id" />
            </div>

            @can('update', $profile)
                <livewire:profile.background-editor />
                <livewire:profile.study-record-editor />
            @endcan

            <livewire:profile.reading-log-editor />
            <livewire:profile.portfolio-editor />
            <livewire:profile.article-editor />
            <livewire:profile.course-editor />
        </div>

        {{-- Side bar: Profile section --}}
        <div class="col-span-3 space-y-2 p-3 bg-white shadow sm:rounded-lg">
            <div class="block md:hidden">
                <livewire:profile.background-section :userId="$profile->user_id" key="background-mobile" />
            </div>
            <livewire:profile.profile-section :userId="$profile->user_id" />
            <livewire:profile.bio-section :userId="$profile->user_id" />
            <livewire:profile.user-skills-section :userId="$profile->user_id" />
            <livewire:profile.experiences-section :userId="$profile->user_id" />

            @can('update', $profile)
                <livewire:profile.profile-editor />
                <livewire:profile.bio-editor />
                <livewire:profile.user-skill-editor />
                <livewire:profile.experience-editor />
            @endcan

        </div>
    </div>
</x-app-layout>
