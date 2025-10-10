@props(['label', 'id', 'name'])

<div>
    <x-input-label :for="$id" :value="$label" class="text-lg" />
    <x-text-input :id="$id" type="datetime-local" class="mt-1" wire:model="{{ $name }}"/>
    <x-input-error :messages="$errors->userDeletion->get($name)" class="mt-2" />
</div>

