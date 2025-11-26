<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5 md:py-12 mx-5 md:mx-10 lg:mx-56 font-garamond flex flex-col gap-10 md:gap-16">
        <section class="mt-8 max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row items-center">
            <div class="flex-1 flex flex-col justify-around items-center gap-6">
                <h2 class="text-3xl md:text-4xl text-white font-semibold text-left">Grow your profile<br><span
                        class="ml-20"></span>at every step your learn
                </h2>
                <p class="text-md text-gray-200 text-left text-wrap">Centralise all your learning records and
                    achievements
                    in one place <br> to showcase your skills, knowledge, and learning ability</p>
                {{-- Display image here in smartphones --}}
                <div class="block overflow-hidden md:ml-10 rounded-lg sm:w-56 md:hidden">
                    <img src="{{ asset('images/profile-page.png') }}" alt="profile page">
                </div>
                <div class="flex flex-ronw gap-2 items-start">
                    <img src="{{ asset('images/icons/checked-mark.svg') }}" alt="check icon" class="w-6">
                    <p class="text-md text-white text-left">Record your study hours, reading logs, and more as you
                        progress</p>
                </div>
                @guest
                    <div class="flex flex-row gap-2 items-center justify-start">
                        <x-secondary-button :href="route('login')">Login</x-secondary-button>
                        <x-primary-button :href="route('register')">Register</x-primary-button>
                    </div>
                @endguest
            </div>
            {{-- Hide this image in smartphone --}}
            <div class="hidden md:block md:w-96 overflow-hidden ml-10 rounded-lg">
                <img src="{{ asset('images/profile-page.png') }}" alt="profile page">
            </div>

        </section>
        <section class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col items-center gap-6">
            <div class="text-white bg-green-900 px-3 py-1 rounded-full">Features</div>
            <h2 class="text-3xl lg:text-4xl text-white font-semibold text-center md:text-left ">
                Turn your hardwork into career leverage
            </h2>
            <p class="text-lg text-white text-center md:text-left text-wrap">Enhance your resume with proof of progress that recruiters
                can trust while fueling your motivation to
                keep learning</p>
            <ul class="w-full flex flex-col items-center md:flex-row justify-between gap-6">
                <li class="bg-neutral-200 size-64 p-4 lg:p-8 rounded-lg flex flex-col gap-1">
                    <img src="{{ asset('images/icons/pen.svg') }}" alt="pen icon" class="w-12">
                    <h3 class="text-xl underline font-semibold text-gray-600">Record your progress</h3>
                    <p class="text-md font-thin text-gray-600">
                        Record your study hours, reading logs, courses, licenses & certifications, portfolios, published
                        articles, major projects at one place
                    </p>
                </li>
                <li class="bg-neutral-200 size-64 p-4 lg:p-8 rounded-lg flex flex-col gap-1">
                    <img src="{{ asset('images/icons/pen.svg') }}" alt="pen icon" class="w-12">
                    <h3 class="text-xl underline font-semibold text-gray-600">Record your progress</h3>
                    <p class="text-md font-thin text-gray-600">
                        Record your study hours, reading logs, courses, licenses & certifications, portfolios, published
                        articles, major projects at one place
                    </p>
                </li>
                <li class="bg-neutral-200 size-64 p-4 lg:p-8 rounded-lg flex flex-col gap-1">
                    <img src="{{ asset('images/icons/pen.svg') }}" alt="pen icon" class="w-12">
                    <h3 class="text-xl underline font-semibold text-gray-600">Record your progress</h3>
                    <p class="text-md font-thin text-gray-600">
                        Record your study hours, reading logs, courses, licenses & certifications, portfolios, published
                        articles, major projects at one place
                    </p>
                </li>
            </ul>
        </section>
        <section class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4 items-center">
            <div class="text-white bg-green-900 px-3 py-1 rounded-full">How to use</div>
            <ul class="flex flex-col gap-10">
                <li class="flex flex-col md:flex-row gap-3 bg-neutral-200 p-8 rounded-lg">
                    <div class=" flex-1 flex flex-col justify-center gap-1 md:gap-3">
                        <div class="flex flex-row items-center gap-2">
                            <div
                                class=" bg-green-900 w-10 h-10 text-center flex justify-center items-center rounded-full text-white font-bold">
                                1</div>
                            <h3 class="text-2xl md:text-3xl text-gray-600 font-semibold text-left">
                                Create your profile
                            </h3>
                        </div>
                        <p class="text-gray-400 text-lg">Add all the basic information</p>
                        <p class="text-md font-thin text-gray-600 text-left text-wrap">Create your profile by adding
                            name, location,
                            introduction, career history, skills and entering your Github and LinkedIn URL.</p>
                    </div>
                    <div class="flex-1 overflow-hidden rounded-lg">
                        <img src="{{ asset('images/profile-page.png') }}" alt="profile page">
                    </div>
                </li>
                <li class="flex flex-col md:flex-row gap-3 bg-neutral-200 p-8 rounded-lg mt-5">
                    <div class=" flex-1 flex flex-col justify-center gap-1 md:gap-3">
                        <div class="flex flex-row items-center gap-2">
                            <div
                                class=" bg-green-900 w-10 h-10 text-center flex justify-center items-center rounded-full text-white font-bold">
                                2</div>
                            <h3 class="text-2xl md:text-3xl flex-1 text-gray-600 font-semibold text-left text-wrap">
                                Record your learning progress
                            </h3>
                        </div>
                        <p class="text-gray-400 text-lg">Update your activities</p>
                        <p class="text-md font-thin text-gray-600 text-left text-wrap">Just click the plus icon at the
                            top right
                            corner of each section and start adding your learning records. Click the pen icon for
                            editing the existing records.</p>
                    </div>
                    <div class="flex-1 overflow-hidden rounded-lg">
                        <img src="{{ asset('images/profile-page.png') }}" alt="profile page">
                    </div>
                </li>
            </ul>
        </section>

        <div class="flex flex-col items-center gap-3 mb-12">
            <h2 class="text-3xl lg:text-4xl text-white">
                Make your effort count
            </h2>
            <p class="text-md text-gray-100">
                Start creating your own growfile
            </p>
            @guest
                <div class="flex flex-row gap-2 items-center">
                    <x-secondary-button :href="route('login')">Login</x-secondary-button>
                    <x-primary-button :href="route('register')">Register</x-primary-button>
                </div>
            @endguest
        </div>
    </div>
</x-app-layout>
