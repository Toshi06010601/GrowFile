{{-- Profile section --}}
<section class="space-y-2 p-8 bg-white shadow sm:rounded-lg">

    <header class="flex flex-row justify-end">
        <x-section.partials.edit-icon class="mr-10" x-data=""
            x-on:click="
                $dispatch('open-modal', 'edit-profile');
                $dispatch('set-profile', { id: null });" />
    </header>

    <div x-data="{
        profile: @js($profile),
        showProfile() {
            console.log(this.profile)
        },
    
    }" x-init="showProfile()">

    </div>

    {{-- Display study records below --}}
    <div class="flex flex-col justify-start">
        <div class="w-28 h-28 rounded-full overflow-hidden mx-auto">
            <img src="{{ $profile->profile_image }}" alt="profile image" class="w-full h-full object-cover">
        </div>
        <div class="mx-auto mt-2">
            <h3 class="text-2xl"><strong>{{ $profile->full_name }}</strong></h3>
        </div>
        <div class="mx-auto mt-2">
            <p class="text-gray-600 leading-none">{{ $profile->headline }}</p>
        </div>
        <div class="mx-auto mt-2">
            <div class="text-white bg-green-600 rounded-full py-1 px-2 text-center">{{ $profile->job_status }} to work</div>
        </div>

        <div class="mx-auto mt-2 flex flex-row gap-1">
            <img src={{ asset('images/icons/pin.svg') }} alt="location pin" class="w-4">
            <p class="text-gray-600 leading-none">{{ $profile->location }}</p>
        </div>

        <div class="flex flex-row justify-center gap-3 mt-3">
            <figure class="flex flex-col">
                <a href={{ $profile->github_link }}>
                    <img src={{ asset('images/icons/github.svg') }} alt="location pin" class="w-8 mx-auto">
                    <figcaption class="text-gray-600 leading-none mt-2">
                        Github
                    </figcaption>
                </a>
            </figure>
            <figure class="flex flex-col">
                <a href={{ $profile->linkedin_link }}>
                    <img src={{ asset('images/icons/linkedin.svg') }} alt="location pin" class="w-8 mx-auto">
                    <figcaption class="text-gray-600 leading-none mt-2">
                        Linkedin
                    </figcaption>
                </a>
            </figure>
        </div>
    </div>


</section>
