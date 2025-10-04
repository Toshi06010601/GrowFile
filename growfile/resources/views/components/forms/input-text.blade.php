@props(['label', 'id', 'name', 'placeholder'])

<div>
    <x-input-label :for="$id" :value="{{ __($label) }}" class="text-lg" />
    <x-text-input :id="$id" :name="$name" type="text" class="mt-1 block w-full" :placeholder="{{ __($placeholder) }}" />
    <x-input-error :messages="$errors->userDeletion->get($name)" class="mt-2" />
</div>
