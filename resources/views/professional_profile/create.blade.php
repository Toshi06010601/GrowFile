<x-guest-layout>
    <form method="POST" action="{{ route('professional_profile.store') }}">
        @csrf

        <h2 class="text-2xl font-semibold my-5 text-center">
            {{ __('auth.start-creating-profile') }}
        </h2>

        <!-- Full Name -->
        <div>
            <x-input-label for="full-name" :value="__('auth.full-name')" />
            <x-text-input id="full-name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" required autofocus autocomplete="first name" />
            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('auth.confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
