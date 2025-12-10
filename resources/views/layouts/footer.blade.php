<footer class="sm:min-h-56 flex flex-col justify-center bg-white border-b border-gray-100 px-10 sm:px-40">
    <div class="flex flex-row justify-around gap-10 items-start pt-5 sm:pt-8 pb-8">
        <figure class="flex-1 flex flex-col max-w-96">
            <!-- Logo -->
            <div class="shrink-0 flex items-center justify-center sm:justify-start">
                <a href="{{ route('home') }}">
                    <x-application-logo class="block h-12 sm:h-16 w-auto" />
                </a>
            </div>
            <figcaption class="text-center sm:text-left text-sm sm:text-lg font-light text-gray-600">
                Let us help you showcase your learning ability to recruiters and expand your network with other
                like-minded engineers
            </figcaption>
        </figure>
        <div class="flex flex-col sm:flex-row sm:justify-around justify-start gap-3 sm:gap-10">
                @if (Route::is('home'))
                    <nav class="flex flex-col gap-1 max-w-72 items-start">
                        <h3 class="text-lg  sm:text-2xl font-extrabold">Page map</h3>

                        <div class="ml-1 text-sm sm:text-lg font-light text-gray-600 flex flex-col gap-1 items-start">
                            <a href="#features" class="hover:text-black">
                                <p>Features</p>
                            </a>

                            <a href="#how-to-use" class="hover:text-black">
                                <p>How to use</p>
                            </a>
                        </div>
                    </nav>
                @endif
                <nav class="flex flex-col gap-1 max-w-72 items-start">
                    <h3 class="text-lg sm:text-2xl font-extrabold">Site map</h3>
    
                    <div class="ml-1 text-sm sm:text-lg font-light text-gray-600 flex flex-col gap-1 items-start">
                        <a href="{{ route('home') }}" class="hover:text-black">
                            <p>Home</p>
                        </a>
    
                        <a href="{{ route('professional_profile.index') }}" class="hover:text-black">
                            <p>Network</p>
                        </a>
    
                        @auth
                            <a class="flex flex-col justify-end items-center hover:text-black"
                                href={{ route('professional_profile.show', $userProfile->slug) }}>
                                <p>Profile</p>
                            </a>
                        @endauth
    
                        <a href="{{ route('profile.edit') }}" class="hover:text-black">
                            <p>Account</p>
                        </a>
                    </div>
                </nav>
            </div>
    </div>
</footer>
