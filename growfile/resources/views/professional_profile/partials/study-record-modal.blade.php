<x-modal name="edit-study-record" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <img src=" {{ asset('images/icons/close.svg') }}" alt="close-icon"
        class="w-7 absolute top-0.5 left-0.5 cursor-pointer hover:scale-110 bg-white border-2 border-black rounded-sm"
        x-data="" x-on:click="$dispatch('close')">
    <form method="post" action="{{ route('profile.destroy') }}" class="px-6 pt-14 pb-6">
        @csrf
        @method('patch')

        <h1 class="text-2xl font-medium text-gray-900">
            {{ __('Edit study record') }}
        </h1>

        <hr class="h-0.5 border-none bg-gray-500 my-3">

        <x-input-label for="project-name" value="{{ __('Project Name') }}" class="text-lg" />
        <x-text-input id="project-name" name="project-name" type="text" class="mt-1 block w-full"
            placeholder="{{ __('Project Name') }}" />
        <x-input-error :messages="$errors->userDeletion->get('project-name')" class="mt-2" />

        <x-input-label for="description" value="{{ __('Description') }}" class="text-lg mt-4" />
        <x-text-input id="description" name="description" type="text" class="mt-1 block w-full"
            placeholder="{{ __('What have you worked on?') }}" />
        <x-input-error :messages="$errors->userDeletion->get('description')" class="mt-2" />

        <div class="flex flex-row justify-start mt-4">
            <div>
                <x-input-label for="start-date" value="{{ __('Start Date') }}" class="text-lg" />
                <x-text-input id="start-date" name="start-date" type="date" class="mt-1" />
                <x-input-error :messages="$errors->userDeletion->get('start-date')" class="mt-2" />
            </div>

            <div class="ml-20">
                <x-input-label for="start-time" value="{{ __('Start Time') }}" class="text-lg" />
                <x-text-input id="start-time" name="start-time" type="time" class="mt-1" />
                <x-input-error :messages="$errors->userDeletion->get('start-time')" class="mt-2" />
            </div>

        </div>

        <div class="flex flex-row justify-start mt-4">
            <div>
                <x-input-label for="end-date" value="{{ __('End Date') }}" class="text-lg" />
                <x-text-input id="end-date" name="end-date" type="date" class="mt-1" />
                <x-input-error :messages="$errors->userDeletion->get('end-date')" class="mt-2" />
            </div>

            <div class="ml-20">
                <x-input-label for="end-time" value="{{ __('End Time') }}" class="text-lg" />
                <x-text-input id="end-time" name="end-time" type="time" class="mt-1" />
                <x-input-error :messages="$errors->userDeletion->get('end-time')" class="mt-2" />
            </div>

        </div>

        <div class="flex flex-row justify-end mt-6">
            <x-primary-button type="submit" x-on:click="$dispatch('close')">
                {{ __('Save') }}
            </x-primary-button>
        </div>

    </form>
</x-modal>
