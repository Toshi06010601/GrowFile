@props(['label', 'id', 'name'])

<div>
    <x-input-label :for="$id" :value="$label" class="text-lg" />
    <x-text-input :id="$id" type="date" class="mt-1" wire:model="{{ $name }}" />
    <div>
        @error($name)
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
    </div>
</div>
