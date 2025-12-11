{{-- Profile section --}}
<div class="py-1 sm:py-0 space-y-2 text-base sm:text-xl">

    {{-- Display profile details below for laptop --}}
    <div class="ml-5 mb-2 sm:m-0 flex flex-row sm:flex-col justify-start items-center relative">

        {{-- Profile header area --}}
        <div class="mx-auto max-w-xs flex flex-col justify-around items-start">
            <div class="relative w-24 sm:w-32 mx-auto">
                {{-- Profile image --}}
                <div class="size-20 sm:size-28 rounded-full overflow-hidden mx-auto border-2 border-white shadow-md">
                    <img src="{{ $profile->profile_image_path }}" alt="profile image" class="w-full h-full object-cover">
                </div>

                {{-- Laptop: Show edit icon for owner --}}
                @can('update', $profile)
                    <x-section.edit-icon class="hidden sm:block absolute z-10 bottom-0 right-0" x-data=""
                        x-on:click="
                $dispatch('set-profile', { id: {{ $profile->id }} });" />
                @endcan
            </div>

            {{-- full name --}}
            <div class="mx-auto mt-2">
                <h3 class="text-center text-lg leading-5 sm:text-2xl"><strong>{{ $profile->full_name }}</strong></h3>
            </div>

            {{-- headline --}}
            <div class="mx-auto mt-2">
                <p class="text-center text-base sm:text-xl text-gray-600 leading-none">{{ $profile->headline }}</p>
            </div>
        </div>

        {{-- Profile details --}}
        <div class="flex-1 min-w-[150px] flex flex-col justify-center items-center gap-1 px-1">
            {{-- job status --}}
            <div class="sm:mx-auto mt-2">
                <div class="text-white bg-green-900 rounded-full py-1 px-2 text-center">
                    {{ str_replace('_', ' ', $profile->job_status) }}</div>
            </div>

            {{-- location --}}
            <div class="mx-5 sm:mx-auto mt-2 flex flex-row justify-center items-start gap-0">
                <img src={{ asset('images/icons/pin.svg') }} alt="location pin" class="w-4">
                <p class="text-gray-600 text-center leading-none">{{ $profile->location }}</p>
            </div>

            {{-- Github link and Linkedin --}}
            <div class="flex flex-row justify-center gap-3 mt-5 text-sm sm:text-base">
                {{-- Github --}}
                <figure class="flex flex-col">
                    <a href={{ $profile->github_link }} target="_blank" class="hover:scale-105">
                        <img src={{ asset('images/icons/github.svg') }} alt="location pin" class="w-8 mx-auto">
                        <figcaption class="text-gray-600 leading-none mt-2">
                            Github
                        </figcaption>
                    </a>
                </figure>
                {{-- LinkedIn --}}
                <figure class="flex flex-col">
                    <a href={{ $profile->linkedin_link }} target="_blank" class="hover:scale-105">
                        <img src={{ asset('images/icons/linkedin.svg') }} alt="location pin" class="w-8 mx-auto">
                        <figcaption class="text-gray-600 leading-none mt-2">
                            Linkedin
                        </figcaption>
                    </a>
                </figure>
            </div>

            {{-- Follow button --}}
            @auth
                @if (Auth::id() !== $profile->user_id)
                    <livewire:Profile.Partials.FollowButton :userId="$profile->user_id" :isFollowing="!is_null($profile->user->authFollows)" idPrefix="laptop" />
                @endif
            @endauth
        </div>


        {{-- Mobile: Show edit icon for owner --}}
        @can('update', $profile)
            <x-section.edit-icon class="sm:hidden absolute -bottom-8 right-2" x-data=""
                x-on:click="
                    $dispatch('set-profile', { id: {{ $profile->id }} });" />
        @endcan
    </div>

</div>
