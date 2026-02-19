<x-app-layout>
    <div class="py-5 flex flex-col-reverse md:grid md:grid-cols-8 gap-4 px-5 sm:px-16 w-full max-w-7xl mx-auto">
        {{-- Main: Learning records section --}}
        <div class="col-span-5">
            <div class="hidden md:block">
                <livewire:profile.background.background-section :userId="$profile->user_id" key="background-desktop" />
            </div>

            <div class="w-full flex flex-col gap-6">
                <livewire:study-record.study-record-dashboard :userId="$profile->user_id" />
                <livewire:study-record.study-record-chart :userId="$profile->user_id" />
                <livewire:reading-log.reading-log-section :userId="$profile->user_id" />
                <livewire:course.course-section :userId="$profile->user_id" />
                <livewire:article.article-section :userId="$profile->user_id" />
                <livewire:portfolio.portfolio-section :userId="$profile->user_id" />
            </div>

            @can('update', $profile)
                <livewire:profile.background.background-editor />
            @endcan
            <livewire:study-record.study-record-editor />
            <livewire:reading-log.reading-log-editor />
            <livewire:portfolio.portfolio-editor />
            <livewire:article.article-editor />
            <livewire:course.course-editor />
        </div>

        {{-- Side bar: Profile section --}}
        <div class="col-span-3 space-y-2 p-3 bg-white shadow sm:rounded-lg">
            <div class="block md:hidden">
                <livewire:profile.background.background-section :userId="$profile->user_id" key="background-mobile" />
            </div>
            <livewire:profile.profile-section :userId="$profile->user_id" />
            <livewire:profile.bio.bio-section :userId="$profile->user_id" />
            <livewire:user-skill.user-skill-section :userId="$profile->user_id" />
            <livewire:experience.experience-section :userId="$profile->user_id" />

            @can('update', $profile)
                <livewire:profile.profile-editor />
                <livewire:profile.bio.bio-editor />
                <livewire:user-skill.user-skill-editor />
                <livewire:experience.experience-editor />
            @endcan

        </div>
    </div>
</x-app-layout>
