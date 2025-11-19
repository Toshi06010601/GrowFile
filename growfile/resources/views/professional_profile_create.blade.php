<x-guest-layout>
    <form method="POST" action="{{ route('professional_profile.store') }}">
        @csrf

        <h2 class="text-2xl font-semibold my-5 text-center">
            Let's start creating your profile!
        </h2>

        <!-- First Name -->
        <div>
            <x-input-label for="first-name" :value="__('First Name')" />
            <x-text-input id="first-name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-input-label for="last-name" :value="__('Last Name')" />
            <x-text-input id="last-name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="last name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
