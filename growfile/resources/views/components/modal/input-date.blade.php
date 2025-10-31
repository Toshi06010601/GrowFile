@props(['label', 'id', 'name'])

<div>
    <x-input-label :for="$id" :value="$label" class="text-lg" />
    <x-text-input :id="$id" :name="$name" type="date" class="mt-1" />
    <x-input-error :messages="$errors->userDeletion->get($name)" class="mt-2" />
</div>

