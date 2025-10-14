@props(['label', 'id', 'name'])

<div>
    <x-input-label :for="$id" :value="$label" class="text-lg mt-4" />
    <x-text-input :id="$id" type="datetime-local" class="mt-1" wire:model="{{ $name }}" />
    <div>
        @error($name)
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
    </div>
</div>
