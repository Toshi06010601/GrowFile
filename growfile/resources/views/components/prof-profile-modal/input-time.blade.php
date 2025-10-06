@props(['label', 'id', 'name'])

<div class="ml-20">
    <x-input-label :for="$id" :value="$label" class="text-lg" />
    <x-text-input :id="$id" :name="$name" type="time" class="mt-1" />
    <x-input-error :messages="$errors->userDeletion->get($name)" class="mt-2" />
</div>
