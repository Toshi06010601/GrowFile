{{-- Profile section --}}
<div class="space-y-2">
    {{-- Display profile details below --}}
    <div class="flex flex-col justify-start">

        {{-- Profile header area --}}
        <div class="relative w-32 mx-auto">
            {{-- Profile image --}}
            <div class="w-28 h-28 rounded-full overflow-hidden mx-auto">
                <img src="/{{ $profile->profile_image_path }}" alt="profile image" class="w-full h-full object-cover">
            </div>

            {{-- Show edit icon for owner --}}
            @can('update', $profile)
                <x-section.edit-icon class="absolute z-10 bottom-0 right-0" x-data=""
                    x-on:click="
                $dispatch('set-profile', { id: {{ $profile->id }} });" />
            @endcan
        </div>

        {{-- Profile details --}}

        {{-- full name --}}
        <div class="mx-auto mt-2">
            <h3 class="text-2xl"><strong>{{ $profile->full_name }}</strong></h3>
        </div>

        {{-- headline --}}
        <div class="mx-auto mt-2">
            <p class="text-gray-600 leading-none">{{ $profile->headline }}</p>
        </div>

        {{-- job status --}}
        <div class="mx-auto mt-2">
            <div class="text-white bg-green-600 rounded-full py-1 px-2 text-center">
                {{ str_replace('_', ' ', $profile->job_status) }}</div>
        </div>

        {{-- location --}}
        <div class="mx-auto mt-2 flex flex-row gap-1">
            <img src={{ asset('images/icons/pin.svg') }} alt="location pin" class="w-4">
            <p class="text-gray-600 leading-none">{{ $profile->location }}</p>
        </div>

        {{-- Github link and Linkedin --}}
        <div class="flex flex-row justify-center gap-3 mt-3">
            {{-- Github --}}
            <figure class="flex flex-col">
                <a href={{ $profile->github_link }} target="_blank">
                    <img src={{ asset('images/icons/github.svg') }} alt="location pin" class="w-8 mx-auto">
                    <figcaption class="text-gray-600 leading-none mt-2">
                        Github
                    </figcaption>
                </a>
            </figure>
            {{-- LinkedIn --}}
            <figure class="flex flex-col">
                <a href={{ $profile->linkedin_link }} target="_blank">
                    <img src={{ asset('images/icons/linkedin.svg') }} alt="location pin" class="w-8 mx-auto">
                    <figcaption class="text-gray-600 leading-none mt-2">
                        Linkedin
                    </figcaption>
                </a>
            </figure>
        </div>
    </div>
</div>
