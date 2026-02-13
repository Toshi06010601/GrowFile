<nav x-data="{
    open: false,
    profile_image_path: '{{ $userProfile ? $userProfile->profile_image_path : '' }}',
}" @set-profile-menu-icon.window="profile_image_path = event.detail[0].filePath;"
    class="bg-brand-tertiary-50 border-b border-brand-secondary-100 py-2 pr-5 lg:pr-0">
    <!-- Primary Navigation Menu -->
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between h-16">
            <div class="px-4 w-full flex items-center gap-4 md:gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="hover:scale-105">
                        <x-application-logo class="block h-12 sm:h-16 w-auto" />
                    </a>
                </div>

                <!-- Search Field -->
                <div class="flex flex-row items-center flex-1">
                    <livewire:Navigation.UserSearchField />
                </div>

                <!-- Network button -->
                <div
                    class="hidden md:block text-base leading-4 font-medium text-brand-secondary-500 hover:text-brand-secondary-800 hover:scale-105 focus:outline-none transition ease-in-out duration-150">
                    <a class="flex flex-col justify-center items-center"
                        href="{{ route('professional_profile.index') }}">
                        <img src="{{ asset('/images/icons/people.svg') }}" alt=""
                            class="block h-8 sm:h-9 w-auto" />
                        <p>Network</p>
                    </a>
                </div>

                {{-- For Logged in user --}}
                @auth
                    <!-- Profile button -->
                    <div
                        class="hidden md:block text-base leading-4 font-medium text-brand-secondary-500 hover:text-brand-secondary-800 focus:outline-none transition ease-in-out duration-150">
                        <a class="flex flex-col justify-end items-center hover:scale-105"
                            href={{ route('professional_profile.show', $userProfile ? $userProfile->slug : '') }}>
                            <div class="size-9 rounded-full overflow-hidden">
                                <img src="{{ asset('/images/icons/profile.svg') }}" alt=""
                                    class="w-full h-full object-cover" />
                            </div>
                            <p>Profile</p>
                        </a>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden md:flex md:items-center md:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="flex flex-col justify-center pr-3 py-2 border border-transparent text-base leading-4 font-medium rounded-md text-brand-secondary-500 bg-secondary-background-50 hover:text-brand-secondary-800 hover:scale-105 focus:outline-none transition ease-in-out duration-150">
                                    <div class="ml-1 size-9 sm:size-12 rounded-full overflow-hidden border-2">
                                        <img :src="'/storage/' + profile_image_path" alt="profile image"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div class="inline-flex justify-center items-center">
                                        <div>Me</div>

                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>

                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('My Account') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                {{-- For guest user --}}
                @else
                    <!-- Login menu -->
                    <div class="hidden lg:flex sm:items-center sm:ms-6 sm:gap-2">
                        <x-primary-button :href="route('register')" class="hover:scale-105">Start Now</x-primary-button>
                        <x-secondary-button :href="route('login')" class="hover:scale-105">Login</x-secondary-button>
                    </div>
                @endauth


            </div>


            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-brand-secondary-400 hover:text-brand-secondary-500 hover:bg-brand-secondary-100 focus:outline-none focus:bg-brand-secondary-100 focus:text-brand-secondary-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="block md:hidden">
        <div class="pt-2 pb-3">
            <x-responsive-nav-link :href="route('home')" class="flex flex-row gap-2 hover:bg-brand-secondary-300">
                <img src="{{ asset('/images/icons/house.svg') }}" alt="" class="block h-6 w-auto" />
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('professional_profile.index')" class="flex flex-row gap-2">
                <img src="{{ asset('/images/icons/people.svg') }}" alt="" class="block h-6 w-auto" />
                {{ __('Network') }}
            </x-responsive-nav-link>
            {{-- For Logged in user only --}}
            @auth
                <x-responsive-nav-link :href="route('professional_profile.show', $userProfile ? $userProfile->slug : '')" class="flex flex-row gap-2">
                    <img src="{{ asset('/images/icons/profile.svg') }}" alt="" class="block h-6 w-auto" />
                    {{ __('Profile') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-2 pb-1 border-t border-brand-secondary-200">
            {{-- For login user --}}
            @auth
                <div class="mt-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Account') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            {{-- For guest user --}}
            @else
                <div class="mt-2 flex flex-row justify-center gap-3">
                    <x-primary-button :href="route('register')">Start Now</x-primary-button>
                    <x-secondary-button :href="route('login')">Login</x-secondary-button>
                </div>
            @endauth
        </div>
    </div>
</nav>
