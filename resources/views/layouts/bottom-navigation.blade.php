<nav class="fixed bottom-0 left-0 right-0 z-40 flex py-3 w-full justify-around items-center border-t border-brand-secondary-100 bg-brand-tertiary-50 pb-safe md:hidden">
    <!-- Home button -->
    <x-responsive-nav-link :href="route('home')">
        <img src="{{ asset('/images/icons/house.svg') }}" alt="Home" class="block h-8 w-auto mb-1" />
        <p>Home</p>
    </x-responsive-nav-link>
    <!-- Network button -->
    <x-responsive-nav-link :href="route('professional_profile.index')">
        <img src="{{ asset('/images/icons/people.svg') }}" alt="Network" class="block h-8 w-auto mb-1" />
        <p>Network</p>
    </x-responsive-nav-link>

    {{-- For Logged in user only --}}
    @auth
        <!-- Profile button -->
        <x-responsive-nav-link :href="route('professional_profile.show', $userProfile ? $userProfile->slug : '')">
            <img src="{{ asset('/images/icons/profile.svg') }}" alt="profile" class="block h-8 w-auto mb-1 mb-1" />
            <p>Profile</p>
        </x-responsive-nav-link>

        <!-- Account button -->
        <x-responsive-nav-link :href="route('profile.edit')">
            <img src="{{ asset('/images/icons/account.svg') }}" alt="Account" class="block h-8 w-auto mb-1" />
            <p>{{ __('Account') }}</p>
        </x-responsive-nav-link>

        <!-- Logout button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')"
                onclick="event.preventDefault();
                                    this.closest('form').submit();">
                <img src="{{ asset('/images/icons/logout.svg') }}" alt="Account" class="block h-8 w-auto mb-1" />
                <p>{{ __('Log Out') }}</p>
            </x-responsive-nav-link>
        </form>
    @endauth

    {{-- For Guest user --}}
    @guest
        <x-responsive-nav-link :href="route('register')">
            <img src="{{ asset('/images/icons/signup.svg') }}" alt="Sign up" class="block h-8 w-auto mb-1" />
            <p>{{ __('Sign up') }}</p>
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('login')">
            <img src="{{ asset('/images/icons/login.svg') }}" alt="Login" class="block h-8 w-auto mb-1" />
            <p>{{ __('Login') }}</p>
        </x-responsive-nav-link>
    @endguest

</nav>
