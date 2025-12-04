<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5 md:py-5 mx-auto font-garamond flex flex-col items-center gap-10 px-5 md:px-10">
        
        {{-- Section 1: Hero --}}
        <section class="mt-3 w-full max-w-5xl flex flex-col md:flex-row items-center">
            <div class="flex-1 flex flex-col justify-around items-start gap-6">
                <div class="mx-auto">
                    <h2 class="text-3xl md:text-4xl text-white font-semibold text-left">Grow your profile</h2>
                    <h2 class="text-3xl md:text-4xl text-white font-semibold text-right">at every step your learn</h2>
                    <p class="text-md text-gray-200 text-center md:text-left text-wrap mt-2">
                        Centralise all your learning records and achievements in one place <br> 
                        to showcase your skills, knowledge, and learning ability
                    </p>
                </div>
                
                {{-- Display image here in smartphones --}}
                <div class="block overflow-hidden md:ml-10 rounded-lg sm:w-56 md:hidden">
                    <img src="{{ asset('images/profile-page.png') }}" alt="profile page">
                </div>
                
                <div class="sm:ml-7 flex flex-col gap-3">
                    <div class="flex flex-row gap-2 items-start">
                        <img src="{{ asset('images/icons/checked-mark.svg') }}" alt="check icon" class="w-6">
                        <p class="text-md text-white text-left">
                            Record your study hours, reading logs, and more as you progress
                        </p>
                    </div>
                    
                    <div class="flex flex-row gap-2 items-start">
                        <img src="{{ asset('images/icons/checked-mark.svg') }}" alt="check icon" class="w-6">
                        <p class="text-md text-white text-left">
                            Follow other engineers with similar skillset to learn from their outputs
                        </p>
                    </div>
                </div>
                
                @guest
                    <div class="flex flex-row gap-2 items-center justify-start">
                        <x-secondary-button :href="route('login')" class="hover:scale-105">Login</x-secondary-button>
                        <x-primary-button :href="route('register')" class="hover:scale-105">Register</x-primary-button>
                    </div>
                @endguest
            </div>
            
            {{-- Hide this image in smartphone --}}
            <div class="hidden sm:block sm:flex-1 sm:w-96 sm:p-7 overflow-hidden ml-10 rounded-lg">
                <img src="{{ asset('images/profile-page.png') }}" alt="profile page">
            </div>
        </section>

        {{-- Section 2: Features --}}
        <section class="w-full max-w-5xl flex flex-col items-center" id="features">
            <div class="text-white bg-green-900 px-3 py-1 mt-5 sm:mt-10 rounded-full">Features</div>
            <h2 class="mt-4 text-3xl lg:text-4xl text-white font-semibold text-center md:text-left">
                Turn your hardwork into career leverage
            </h2>
            <p class="mt-1 text-md sm:text-lg text-gray-200 text-center md:text-left text-wrap">
                Enhance your resume with proof of progress that recruiters can trust while fueling your motivation to keep learning
            </p>
            
            <ul class="mt-8 flex flex-col items-center md:flex-row justify-center gap-10  sm:gap-24 w-full">
                <x-welcome.feature-item img_path="images/icons/pen.svg" img_alt="pen icon" title="Record your progress" description="Record your study hours, reading logs, courses, licenses & certifications, portfolios, published articles, major projects at one place" />
                <x-welcome.feature-item img_path="images/icons/network.svg" img_alt="network icon" title="Connect with other engineers" description="Find other engineers to get inspirations on books, courses, certifications, and portfolios to boost your learning and motivate yourself with their progress" />
            </ul>
        </section>

        {{-- Section 3: How to use --}}
        <section class="w-full max-w-5xl flex flex-col items-center" id="how-to-use">
            <div class="text-white bg-green-900 px-3 py-1 rounded-full mt-5 sm:mt-10">How to use</div>
            
            <ul class="mt-8 flex flex-col gap-8 w-full">
                <x-welcome.how-to-use-item img_path='images/profile-page.png' img_alt='profile image' numbering="1" title="Create your profile" sub_title="Add all the basic information" description="Create your profile by adding name, location, introduction, career history, skills and entering your Github and LinkedIn URL."/>
                <x-welcome.how-to-use-item img_path='images/profile-page.png' img_alt='profile image' numbering="2" title="Record your progress" sub_title="Update your activities" description="Just click the plus icon at the top right corner of each section and start adding your learning records. Click the pen icon for editing the existing records."/>
            </ul>
        </section>

        {{-- Section 4: Closing --}}
        <section class="w-full max-w-6xl flex flex-col items-center gap-3 mb-12 mt-10">
            <h2 class="text-3xl lg:text-4xl text-white">
                Make your effort count
            </h2>
            <p class="text-md text-gray-100">
                Start creating your own growfile
            </p>
            @guest
                <div class="flex flex-row gap-2 items-center">
                    <x-secondary-button :href="route('login')" class="hover:scale-105">Login</x-secondary-button>
                    <x-primary-button :href="route('register')" class="hover:scale-105">Register</x-primary-button>
                </div>
            @endguest
        </section>
    </div>
</x-app-layout>