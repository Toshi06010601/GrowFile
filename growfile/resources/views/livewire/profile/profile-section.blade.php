{{-- Profile section --}}
<div class="py-1 sm:py-0 space-y-2 text-md sm:text-lg">

    {{-- Display profile details below for laptop --}}
    <div class="hidden sm:flex flex-col justify-start">

        {{-- Profile header area --}}
        <div class="relative w-32 mx-auto">
            {{-- Profile image --}}
            <div class="w-28 h-28 rounded-full overflow-hidden mx-auto">
                <img src="{{ $profile->profile_image_path }}" alt="profile image" class="w-full h-full object-cover">
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
            <h3 class="text-xl sm:text-2xl"><strong>{{ $profile->full_name }}</strong></h3>
        </div>

        {{-- headline --}}
        <div class="mx-auto mt-2">
            <p class="text-gray-600 leading-none">{{ $profile->headline }}</p>
        </div>

        {{-- job status --}}
        <div class="mx-auto mt-2">
            <div class="text-white bg-green-900 rounded-full py-1 px-2 text-center">
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
                <a href={{ $profile->github_link }} target="_blank" class="hover:scale-105">
                    <img src={{ asset('images/icons/github.svg') }} alt="location pin" class="w-8 mx-auto">
                    <figcaption class="text-gray-600 leading-none mt-2">
                        Github
                    </figcaption>
                </a>
            </figure>
            {{-- LinkedIn --}}
            <figure class="flex flex-col">
                <a href={{ $profile->linkedin_link }} target="_blank" class="hover:scale-105" >
                    <img src={{ asset('images/icons/linkedin.svg') }} alt="location pin" class="w-8 mx-auto">
                    <figcaption class="text-gray-600 leading-none mt-2">
                        Linkedin
                    </figcaption>
                </a>
            </figure>
        </div>
        
        {{-- Follow button --}}
        @auth
            @if(Auth::id() !== $profile->user_id)
                <livewire:FollowButton 
                    :userId="$profile->user_id" 
                    :isFollowing="!is_null($profile->user->authFollows)"
                    idPrefix="laptop"
                />  
            @endif
        @endauth
    </div>

    {{-- Display profile details below for phone --}}
    <div class="sm:hidden flex flex-row justify-start relative">

        {{-- Profile header area --}}
        <div class="ml-5 flex flex-col justify-around">
            <div class="w-24 mx-auto">
                {{-- Profile image --}}
                <div class="size-20 rounded-full overflow-hidden mx-auto">
                    <img src="{{ $profile->profile_image_path }}" alt="profile image"
                        class="w-full h-full object-cover">
                </div>
            </div>

            {{-- Github link and Linkedin --}}
            <div class="flex flex-row justify-center gap-3 mt-5 text-sm">
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

            {{-- Follow button --}}
            @auth
                @if(Auth::id() !== $profile->user_id)
                    <livewire:FollowButton 
                        :userId="$profile->user_id" 
                        :isFollowing="!is_null($profile->user->authFollows)"
                        idPrefix="mobile"
                    />  
                @endif
            @endauth
        </div>

        {{-- Profile details --}}

        <div class="flex-1 flex flex-col justify-center items-center gap-1 px-1">
            {{-- full name --}}
            <div class="mx-auto mt-2">
                <h3 class="text-lg text-center sm:text-2xl"><strong>{{ $profile->full_name }}</strong></h3>
            </div>
            
            {{-- headline --}}
            <div class="mx-auto mt-2">
                <p class="text-gray-600 text-center leading-none">{{ $profile->headline }}</p>
            </div>
            
            {{-- job status --}}
            <div class="mx-auto mt-2">
                <div class="text-white bg-green-900 rounded-full py-1 px-2 text-center">
                    {{ str_replace('_', ' ', $profile->job_status) }}</div>
                </div>
                
            {{-- location --}}
            <div class="mx-5 mt-2 flex flex-row justify-center items-start gap-0">
                <img src={{ asset('images/icons/pin.svg') }} alt="location pin" class="w-4">
                <p class="text-gray-600 text-center leading-none">{{ $profile->location }}</p>
            </div>


            {{-- Show edit icon for owner --}}
            @can('update', $profile)
                <x-section.edit-icon class="absolute bottom-0 right-0" x-data=""
                    x-on:click="
                    $dispatch('set-profile', { id: {{ $profile->id }} });" />
            @endcan
        </div>
    </div>

</div>
