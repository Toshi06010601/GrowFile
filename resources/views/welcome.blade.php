<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5 font-garamond flex flex-col items-center gap-10 px-5 sm:px-10">

        {{-- Section 1: Hero --}}
        <section class="bg-neutral-700 px-6 sm:px-8 lg:px-12 rounded-lg max-w-7xl flex flex-col justify-between gap-3 sm:gap-10 md:gap-16 lg:flex-row">
            <div class="flex flex-col justify-center sm:text-center py-5 lg:text-left xl:w-5/12 xl:py-12">
                <p class="mb-4 font-semibold text-green-600 md:mb-6 md:text-lg xl:text-xl">Now launching</p>
                <x-welcome.section-title class="text-left">Grow your profile at every step your
                    learn</x-welcome.section-title>
                <div>
                    <x-welcome.section-subtitle class="mb-8 sm:mb-12 text-center sm:text-left md:w-4/5">
                        Centralise all your learning records and achievements in one place
                        to showcase your skills, knowledge, and learning ability
                    </x-welcome.section-subtitle>
                </div>
                @guest
                    <div class="flex flex-col gap-2.5 sm:flex-row sm:justify-center lg:justify-start">
                        <a href="{{ route('login') }}"
                            class="w-full sm:w-auto inline-block rounded-lg bg-green-900 px-8 py-3 text-center text-sm font-semibold text-white outline-none ring-green-300 transition duration-100 hover:bg-green-800 focus-visible:ring active:bg-green-700 md:text-base">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="w-full sm:w-auto inline-block rounded-lg bg-gray-200 px-8 py-3 text-center text-sm font-semibold text-gray-500 outline-none ring-green-300 transition duration-100 hover:bg-gray-300 focus-visible:ring active:text-gray-700 md:text-base">
                            Register
                        </a>
                    </div>
                @endguest
            </div>
            <div class="mx-auto border-none bg-transparent w-10/12  sm:w-[600px] m-2 sm:mx-10 lg:w-auto xl:w-5/12">
                <img src="{{ asset('images/app-image.png') }}" alt="profile page" class="h-full w-full object-contain object-center" />
            </div>
        </section>

        {{-- Section 2: Features --}}
        <section class="w-full max-w-7xl flex flex-col items-center" id="features">
            <x-welcome.section-tag>
                Features
            </x-welcome.section-tag>
            <x-welcome.section-title class="text-center sm:text-left">
                Turn your hardwork into career leverage
            </x-welcome.section-title>
            <div class="mt-1 sm:mt-3">
                <x-welcome.section-subtitle class="text-center sm:text-left">
                    Enhance your resume with proof of progress that recruiters can trust while fueling your motivation
                    to keep learning
                </x-welcome.section-subtitle>
            </div>

            <ul class="mt-8 sm:mt-12 flex flex-col items-center sm:flex-row justify-center gap-10  sm:gap-24 w-full">
                <x-welcome.feature-item img_path="images/icons/pen.svg" img_alt="pen icon" title="Record your progress"
                    description="Record your study hours, reading logs, courses, licenses & certifications, portfolios, published articles, major projects at one place" />
                <x-welcome.feature-item img_path="images/icons/network.svg" img_alt="network icon"
                    title="Connect with other engineers"
                    description="Find other engineers to get inspirations on books, courses, certifications, and portfolios to boost your learning and motivate yourself with their progress" />
            </ul>
        </section>

        {{-- Section 3: How to use --}}
        <section class="w-full max-w-5xl flex flex-col items-center" id="how-to-use">
            <x-welcome.section-tag>How to use</x-welcome.section-tag>

            <ul class="mt-8 flex flex-col gap-16 w-full">
                <x-welcome.how-to-use-item img_path='images/edit-profile.png' img_alt='profile image' numbering="1"
                    title="Create your profile" sub_title="Add all the basic information"
                    description="Create your profile by adding name, location, introduction, career history, skills and entering your Github and LinkedIn URL." />
                <x-welcome.how-to-use-item img_path='images/edit-study-record.png' img_alt='profile image' numbering="2"
                    title="Record your progress" sub_title="Update your activities"
                    description="Just click the plus icon at the top right corner of each section and start adding your learning records. Click the pen icon for editing the existing records." />
            </ul>
        </section>

        {{-- Section 4: Closing --}}
        <section class="w-full max-w-6xl flex flex-col items-center gap-3 sm:gap-5 mb-12 mt-10">
            <x-welcome.section-title class="text-3xl text-center">Make your effort count</x-welcome.section-title>
            <x-welcome.section-subtitle class="text-center">
                    Start creating your own growfile
            </x-welcome.section-subtitle>
            @auth
                <div class="flex flex-row gap-2 items-center">
                    <x-primary-button  :href="route('professional_profile.show', $userProfile->slug)" class="hover:scale-105">Go to my profile</x-primary-button>
                </div>
            @else
                <div class="flex flex-row gap-2 items-center">
                    <x-secondary-button :href="route('login')" class="hover:scale-105">Login</x-secondary-button>
                    <x-primary-button :href="route('register')" class="hover:scale-105">Start Now</x-primary-button>
                </div>
            @endauth
        </section>
    </div>
</x-app-layout>
