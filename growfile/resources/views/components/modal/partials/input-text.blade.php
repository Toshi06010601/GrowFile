@props(['label', 'id', 'name', 'placeholder'])

<div>
    <x-input-label :for="$id" :value="$label" class="text-lg mt-4" />
    <x-text-input :id="$id" :name="$name" type="text" class="mt-1 block w-full" :placeholder="$placeholder" wire:model="{{ $name }}"/>
    <x-input-error :messages="$errors->userDeletion->get($name)" class="mt-2" />
</div>
