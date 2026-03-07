<nav x-data="{
    open: false,
    profile_image_path: '{{ $userProfile ? $userProfile->profile_image_path : '' }}',
}" @set-profile-menu-icon.window="profile_image_path = event.detail.filePath;"
    class="bg-brand-tertiary-50 border-b border-brand-secondary-100 py-2 md:pr-5 lg:pr-0">
    <!-- Primary Navigation Menu -->
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between h-16">
            <div class="px-4 w-full flex items-center gap-4 lg:gap-6">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" wire:navigate.hover class="hover:scale-105">
                        <x-application-logo class="block h-12 sm:h-16 w-auto" />
                    </a>
                </div>

                <!-- Search Field -->
                <div class="flex flex-row items-center flex-1">
                    <livewire:Navigation.UserSearchField />
                </div>

                <!-- Network button -->
                <x-responsive-nav-link :href="route('professional_profile.index')" :isPcView="true" class="hidden md:flex">
                    @if (request()->routeIs('professional_profile.index'))
                        <img src="{{ asset('/images/icons/network-selected.svg') }}" alt="profile"
                            class="block h-8 w-auto mb-1" />
                    @else
                        <img src="{{ asset('/images/icons/network-unselected.svg') }}" alt="profile"
                            class="block h-8 w-auto mb-1" />
                    @endif
                    <p>{{ __('navigation.network') }}</p>
                </x-responsive-nav-link>

                {{-- For Logged in user --}}
                @auth
                    <!-- Profile button -->
                    <x-responsive-nav-link :href="route('professional_profile.show', $userProfile ? $userProfile->slug : '')" :isPcView="true" class="hidden md:flex">
                        @if (request()->routeIs('professional_profile.show'))
                            <img src="{{ asset('/images/icons/edit-selected.svg') }}" alt="profile"
                                class="block h-9 w-auto mb-1" />
                        @else
                            <img src="{{ asset('/images/icons/edit-unselected.svg') }}" alt="profile"
                                class="block h-9 w-auto mb-1" />
                        @endif
                        <p>{{ __('navigation.record') }}</p>
                    </x-responsive-nav-link>

                    <!-- Settings Dropdown -->
                    <div class="hidden md:flex md:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="flex flex-col justify-center items-center border border-transparent text-base leading-4 font-medium rounded-md text-brand-secondary-500 bg-secondary-background-50 hover:text-brand-secondary-800 hover:scale-105 focus:outline-none transition ease-in-out duration-150">

                                    <div class="h-9 w-9 rounded-full overflow-hidden border-2 mb-1">
                                        <img :src="'/storage/' + profile_image_path" alt="profile image"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div class="inline-flex justify-center items-center">
                                        <div>{{ __('navigation.me') }}</div>
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
                                    {{ __('navigation.my-account') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('navigation.logout') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    {{-- For guest user --}}
                @else
                    <!-- Login menu -->
                    <div class="hidden md:flex sm:items-center sm:ms-6 sm:gap-2">
                        <x-primary-button :href="route('register')" wire:navigate.hover
                            class="hover:scale-105">{{ __('navigation.start-now') }}</x-primary-button>
                        <x-secondary-button :href="route('login')" wire:navigate
                            class="hover:scale-105">{{ __('navigation.login') }}</x-secondary-button>
                    </div>
                @endauth


            </div>
        </div>
    </div>


</nav>
