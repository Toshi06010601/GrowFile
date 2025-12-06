<nav x-data="{ 
    open: false,
 }"
 class="bg-white border-b border-gray-100 py-2">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="w-full flex items-center gap-4 md:gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                     <a href="{{ route('home') }}" class="hover:scale-105">
                        <x-application-logo class="block h-12 w-auto" />
                    </a>
                </div>

                <!-- Search Field -->
                <div class="flex flex-row items-center flex-1">
                    <livewire:Navigation.UserSearchField />
                </div>

                <!-- Network button -->
                <div class="hidden sm:block text-xs leading-4 font-medium text-gray-500 hover:text-gray-800 hover:scale-105 focus:outline-none transition ease-in-out duration-150">
                    <a class="flex flex-col justify-center items-center" href="{{ route('professional_profile.index') }}">
                            <img src="{{ asset('/images/icons/people.svg') }}" alt="" class="block h-8 sm:h-9 w-auto" />
                            <p>Network</p>
                    </a>
                </div>

            </div>

            <!-- Login menu -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 sm:gap-2">
                 <x-secondary-button :href="route('login')" class="hover:scale-105">Login</x-secondary-button>
                 <x-primary-button :href="route('register')" class="hover:scale-105">Register</x-primary-button>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
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
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
             <x-responsive-nav-link :href="route('home')" class="flex flex-row gap-2 hover:bg-gray-300">
                <img src="{{ asset('/images/icons/house.svg') }}" alt="" class="block h-6 w-auto" />
                {{ __('Home') }}
            </x-responsive-nav-link>
             <x-responsive-nav-link :href="route('professional_profile.index')" class="flex flex-row gap-2 hover:bg-gray-300">
                <img src="{{ asset('/images/icons/people.svg') }}" alt="" class="block h-6 w-auto" />
                {{ __('Network') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="py-2 border-t border-gray-200">
            <div class="mt-2 flex flex-row justify-center gap-3">
                 <x-secondary-button :href="route('login')">Login</x-secondary-button>
                 <x-primary-button :href="route('register')">Register</x-primary-button>
            </div>
        </div>
    </div>
</nav>
