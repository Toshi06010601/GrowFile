<nav
    class="fixed bottom-0 left-0 right-0 z-40 flex py-3 px-3 w-full justify-around items-center border-t border-brand-secondary-100 bg-brand-tertiary-50 pb-safe md:hidden
    {{ app()->getLocale() === "jp" ? 'text-sm' : 'text-base'}}
    ">
    <!-- Home button -->
    <x-responsive-nav-link :href="route('home')">
        @if (request()->routeIs('home'))
            <img src="{{ asset('/images/icons/home-selected.svg') }}" alt="profile" class="block h-8 w-auto mb-1" />
        @else
            <img src="{{ asset('/images/icons/home-unselected.svg') }}" alt="profile" class="block h-8 w-auto mb-1" />
        @endif
       
        <p>{{ __('navigation.home') }}</p>
    </x-responsive-nav-link>
    <!-- Network button -->
    <x-responsive-nav-link :href="route('professional_profile.index')">
        @if (request()->routeIs('professional_profile.index'))
            <img src="{{ asset('/images/icons/network-selected.svg') }}" alt="profile" class="block h-8 w-auto mb-1" />
        @else
            <img src="{{ asset('/images/icons/network-unselected.svg') }}" alt="profile" class="block h-8 w-auto mb-1" />
        @endif
        <p>{{ __('navigation.network') }}</p>
    </x-responsive-nav-link>

    {{-- For Logged in user only --}}
    @auth
        <!-- Profile button -->
        <x-responsive-nav-link :href="route('professional_profile.show', $userProfile ? $userProfile->slug : '')">
            @if (request()->routeIs('professional_profile.show'))
                <img src="{{ asset('/images/icons/edit-selected.svg') }}" alt="profile" class="block h-8 w-auto mb-1" />
            @else
                <img src="{{ asset('/images/icons/edit-unselected.svg') }}" alt="profile"
                    class="block h-8 w-auto mb-1" />
            @endif
            <p>{{ __('navigation.record') }}</p>
        </x-responsive-nav-link>

        <!-- Setting button -->
        <x-dropdown align="bottom" width="48">
            <x-slot name="trigger">
                <button
                    class="leading-4 font-medium text-brand-secondary-500 hover:text-brand-secondary-800 focus:outline-none transition ease-in-out duration-150">
                    <div class="flex flex-col justify-end items-center hover:scale-105">
                        @if (request()->routeIs('profile.edit'))
                            <img src="{{ asset('/images/icons/account-selected.svg') }}" alt="profile"
                                class="block h-8 w-auto mb-1" />
                        @else
                            <img src="{{ asset('/images/icons/account-unselected.svg') }}" alt="profile"
                                class="block h-8 w-auto mb-1" />
                        @endif
                        <div class="inline-flex justify-center items-center">
                            <div>{{ __('navigation.setting') }}</div>
                        </div>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('navigation.account') }}
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
    @endauth

    {{-- For Guest user --}}
    @guest
        <x-responsive-nav-link :href="route('register')">
            <img src="{{ asset('/images/icons/signup.svg') }}" alt="Sign up" class="block h-8 w-auto mb-1" />
            <p>{{ __('navigation.sign-up') }}</p>
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('login')">
            <img src="{{ asset('/images/icons/login.svg') }}" alt="Login" class="block h-8 w-auto mb-1" />
            <p>{{ __('navigation.login') }}</p>
        </x-responsive-nav-link>
    @endguest

</nav>
