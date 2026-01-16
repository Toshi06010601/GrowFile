@props(['label', 'id', 'name', 'disabled' => false])

<div>
    <x-input-label :for="$id" :value="$label" class="text-lg mt-4" />
    <x-text-input :id="$id" type="date" class="mt-1" wire:model="{{ $name }}" :disabled="$disabled" />
    <div>
        @error($name)
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
    </div>
</div>
