<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-brand-secondary-800 leading-tight">
            {{ __('welcome.home') }}
        </h2>
    </x-slot>

    <div class="py-5 md:py-10 flex flex-col items-center gap-10 px-5 sm:px-10">

        {{-- Section 1: Hero --}}
        <section class="bg-brand-secondary-950 px-6 sm:px-8 lg:px-12 rounded-lg max-w-7xl flex flex-col justify-between gap-3 sm:gap-10 md:gap-16 lg:flex-row">
            <div class="flex flex-col justify-center sm:text-center py-5 lg:text-left xl:w-5/12 xl:py-12">
                <p class="mb-4 font-semibold text-brand-primary-700 md:mb-6 md:text-lg xl:text-xl">{{ __('welcome.now-launching') }}</p>
                <x-welcome.section-title class="text-left">{{ __('welcome.hero-title') }}</x-welcome.section-title>
                <div>
                    <x-welcome.section-subtitle class="mb-8 sm:mb-12 text-center sm:text-left md:w-4/5">
                        {{ __('welcome.hero-subtitle') }}
                    </x-welcome.section-subtitle>
                </div>
                @guest
                    <div class="flex flex-col gap-2.5 sm:flex-row sm:justify-center lg:justify-start">
                       <x-primary-button :href="route('register')" class="w-full sm:w-auto">{{ __('welcome.start-now') }}</x-primary-button>
                    <x-secondary-button :href="route('login')" class="w-full sm:w-auto ">{{ __('welcome.login') }}</x-secondary-button>
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
                {{ __('welcome.features') }}
            </x-welcome.section-tag>
            <x-welcome.section-title class="text-center sm:text-left">
                {{ __('welcome.features-title') }}
            </x-welcome.section-title>
            <div class="mt-1 sm:mt-3">
                <x-welcome.section-subtitle class="text-center sm:text-left">
                    {{ __('welcome.features-subtitle') }}
                </x-welcome.section-subtitle>
            </div>

            <ul class="mt-8 sm:mt-12 flex flex-col items-center sm:flex-row justify-center gap-10  sm:gap-24 w-full">
                <x-welcome.feature-item img_path="images/icons/pen.svg" img_alt="pen icon" :title="__('welcome.record-progress-title')"
                    :description="__('welcome.record-progress-description')" />
                <x-welcome.feature-item img_path="images/icons/network.svg" img_alt="network icon"
                    :title="__('welcome.connect-engineers-title')"
                    :description="__('welcome.connect-engineers-description')" />
            </ul>
        </section>

        {{-- Section 3: How to use --}}
        <section class="w-full max-w-5xl flex flex-col items-center" id="how-to-use">
            <x-welcome.section-tag>{{ __('welcome.how-to-use') }}</x-welcome.section-tag>

            <ul class="mt-8 flex flex-col gap-16 w-full">
                <x-welcome.how-to-use-item img_path='images/edit-profile.png' img_alt='profile image' numbering="1"
                    :title="__('welcome.create-profile-title')" :sub_title="__('welcome.create-profile-subtitle')"
                    :description="__('welcome.create-profile-description')" />
                <x-welcome.how-to-use-item img_path='images/edit-study-record.png' img_alt='profile image' numbering="2"
                    :title="__('welcome.record-activities-title')" :sub_title="__('welcome.record-activities-subtitle')"
                    :description="__('welcome.record-activities-description')" />
            </ul>
        </section>

        {{-- Section 4: Closing --}}
        <section class="w-full max-w-6xl flex flex-col items-center gap-3 sm:gap-5 mb-12 mt-10">
            <x-welcome.section-title class="text-3xl text-center">{{ __('welcome.closing-title') }}</x-welcome.section-title>
            <x-welcome.section-subtitle class="text-center">
                    {{ __('welcome.closing-subtitle') }}
            </x-welcome.section-subtitle>
            @auth
                <div class="flex flex-row gap-2 items-center">
                    <x-primary-button  :href="route('professional_profile.show', ['slug' => $userProfile->slug])">{{ __('welcome.go-to-profile') }}</x-primary-button>
                </div>
            @else
                <div class="flex flex-row gap-2 items-center">
                    <x-primary-button :href="route('register')">{{ __('welcome.start-now') }}</x-primary-button>
                    <x-secondary-button :href="route('login')">{{ __('welcome.login') }}</x-secondary-button>
                </div>
            @endauth
        </section>
    </div>
</x-app-layout>
