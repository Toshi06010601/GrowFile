<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 mx-56 font-garamond">
        <section class="mt-8 max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-row gap-10">
            <div class="flex-1 flex flex-col justify-around">
                <h2 class="text-4xl text-white font-semibold text-left">Grow your profile<br><span class="ml-20"></span>at every step your learn
                </h2>
                <p class="text-md text-gray-200 text-left text-wrap">Centralise all your learning records and
                    achievements
                    in one place <br> to showcase your skills, knowledge, and learning ability</p>
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
            <div class="flex-1 overflow-hidden rounded-lg">
                <img src="{{ asset('images/profile-page.png') }}" alt="profile page">
            </div>

        </section>
        <section class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col items-center gap-4 mt-24">
            <div class="text-white bg-green-900 px-3 py-1 rounded-full">Features</div>
            <h2 class="text-4xl text-white font-semibold text-left">
                Turn your hardwork into career leverage
            </h2>
            <p class="text-lg text-white text-left text-wrap">Enhance your resume with proof of progress that recruiters
                can trust while fueling your motivation to
                keep learning</p>
            <ul class="mt-10 w-full flex flex-row justify-between">
                <li class="bg-neutral-200 w-72 p-8 rounded-lg flex flex-col gap-1">
                    <img src="{{ asset('images/icons/pen.svg') }}" alt="pen icon" class="w-12">
                    <h3 class="text-xl underline font-semibold text-gray-600">Record your progress</h3>
                    <p class="text-md font-thin text-gray-600">
                        Record your study hours, reading logs, courses, licenses & certifications, portfolios, published
                        articles, major projects at one place
                    </p>
                </li>
                <li class="bg-neutral-200 w-72 p-8 rounded-lg flex flex-col gap-1">
                    <img src="{{ asset('images/icons/pen.svg') }}" alt="pen icon" class="w-12">
                    <h3 class="text-xl underline font-semibold text-gray-600">Record your progress</h3>
                    <p class="text-md font-thin text-gray-600">
                        Record your study hours, reading logs, courses, licenses & certifications, portfolios, published
                        articles, major projects at one place
                    </p>
                </li>
                <li class="bg-neutral-200 w-72 p-8 rounded-lg flex flex-col gap-1">
                    <img src="{{ asset('images/icons/pen.svg') }}" alt="pen icon" class="w-12">
                    <h3 class="text-xl underline font-semibold text-gray-600">Record your progress</h3>
                    <p class="text-md font-thin text-gray-600">
                        Record your study hours, reading logs, courses, licenses & certifications, portfolios, published
                        articles, major projects at one place
                    </p>
                </li>
            </ul>
        </section>
        <section class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4 items-center mt-16">
            <div class="text-white bg-green-900 px-3 py-1 rounded-full">How to use</div>
            <ul class="flex flex-col gap-10">
                <li class="flex flex-row gap-3 bg-neutral-200 p-8 rounded-lg">
                    <div class=" flex-1 flex flex-col justify-center gap-3">
                        <div class="flex flex-row gap-2">
                            <div
                                class=" bg-green-900 w-8 h-8 text-center flex justify-center items-center rounded-full text-white font-bold">
                                1</div>
                            <h3 class="text-3xl text-gray-600 font-semibold text-left">
                                Create your profile
                            </h3>
                        </div>
                        <p class="text-gray-600 text-lg">Add all the basic information</p>
                        <p class="text-md font-thin text-gray-600 text-left text-wrap">Create your profile by adding
                            name, location,
                            introduction, career history, skills and entering your Github and LinkedIn URL.</p>
                    </div>
                    <div class="flex-1 overflow-hidden rounded-lg">
                        <img src="{{ asset('images/profile-page.png') }}" alt="profile page">
                    </div>
                </li>
                <li class="flex flex-row gap-3 bg-neutral-200 p-8 rounded-lg mt-5">
                    <div class=" flex-1 flex flex-col justify-center gap-3">
                        <div class="flex flex-row gap-2">
                            <div
                                class=" bg-green-900 w-8 h-8 text-center flex justify-center items-center rounded-full text-white font-bold">
                                2</div>
                            <h3 class="text-3xl text-gray-600 font-semibold text-left">
                                Record your learning progress
                            </h3>
                        </div>
                        <p class="text-gray-600 text-lg">Update your activities</p>
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

        <div class="flex flex-col items-center gap-3 mt-16 mb-12">
            <h2 class="text-4xl text-white">
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
