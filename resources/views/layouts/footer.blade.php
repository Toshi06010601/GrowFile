<div class="bg-white pt-4 sm:pt-10 lg:pt-12">
    <footer class="mx-auto max-w-screen-2xl px-5 md:px-8">
        <div class="mb-16 grid grid-cols-2 gap-12 border-t pt-10 md:grid-cols-4 lg:grid-cols-6 lg:gap-8 lg:pt-12">
            <div class="col-span-full lg:col-span-2 lg:col-start-2">
                <!-- logo - start -->
                <div class="mb-4 lg:-mt-2">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-12 sm:h-16 w-auto" />
                    </a>
                </div>
                <!-- logo - end -->

                <p class="mb-6 text-brand-secondary-500 sm:pr-8">{{ __('footer.footer-description') }}</p>

                <!-- language switcher - start -->
                <div class="flex gap-4">
                    <a href="{{ route('locale.switch', 'en') }}"
                        class="inline-flex items-center gap-2 px-3 py-1 rounded border transition duration-100 {{ app()->getLocale() === 'en' ? 'bg-brand-primary-800 text-white border-brand-primary-800' : 'bg-white text-brand-secondary-600 border-brand-secondary-300 hover:border-brand-primary-800 hover:text-brand-primary-800' }}">
                        <span class="text-lg">🇬🇧</span>
                        <span class="text-sm font-medium">English</span>
                    </a>

                    <a href="{{ route('locale.switch', 'jp') }}"
                        class="inline-flex items-center gap-2 px-3 py-1 rounded border transition duration-100 {{ app()->getLocale() === 'jp' ? 'bg-brand-primary-800 text-white border-brand-primary-800' : 'bg-white text-brand-secondary-600 border-brand-secondary-300 hover:border-brand-primary-800 hover:text-brand-primary-800' }}">
                        <span class="text-lg">🇯🇵</span>
                        <span class="text-sm font-medium">日本語</span>
                    </a>
                </div>
                <!-- language switcher - end -->
            </div>

            <!-- nav - start -->
            @if (Route::is('home'))
                <div>
                    <div class="mb-4 font-bold uppercase tracking-widest text-brand-secondary-800">{{ __('footer.page-map') }}</div>

                    <nav class="flex flex-col gap-4">
                        <div>
                            <a href="#features"
                                class="text-brand-secondary-500 transition duration-100 hover:text-brand-primary-800 active:text-brand-primary-700">{{ __('footer.features') }}</a>
                        </div>

                        <div>
                            <a href="#how-to-use"
                                class="text-brand-secondary-500 transition duration-100 hover:text-brand-primary-800 active:text-brand-primary-700">{{ __('footer.how-to-use') }}</a>
                        </div>
                    </nav>
                </div>
            @else
                <div class="hidden lg:block"></div>
            @endif
            <!-- nav - end -->

            <!-- nav - start -->
            <div>
                <div class="mb-4 font-bold uppercase tracking-widest text-brand-secondary-800">{{ __('footer.site-map') }}</div>

                <nav class="flex flex-col gap-4">
                    <a href="{{ route('home') }}"
                        class="text-brand-secondary-500 transition duration-100 hover:text-brand-primary-800 active:text-brand-primary-700">
                        <p>{{ __('footer.home') }}</p>
                    </a>

                    <a href="{{ route('professional_profile.index') }}"
                        class="text-brand-secondary-500 transition duration-100 hover:text-brand-primary-800 active:text-brand-primary-700">
                        <p>{{ __('footer.network') }}</p>
                    </a>

                    @auth
                        <a class="text-brand-secondary-500 transition duration-100 hover:text-brand-primary-800 active:text-brand-primary-700"
                            href={{ route('professional_profile.show', $userProfile->slug) }}>
                            <p>{{ __('footer.profile') }}</p>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="text-brand-secondary-500 transition duration-100 hover:text-brand-primary-800 active:text-brand-primary-700">
                            <p>{{ __('footer.account') }}</p>
                        </a>
                    @endauth
                </nav>
            </div>
            <!-- nav - end -->
        </div>

        <div class="border-t py-8 text-center text-sm text-brand-secondary-400">© 2025 - GrowFile. {{ __('footer.all-rights-reserved') }}
        </div>
    </footer>
</div>
