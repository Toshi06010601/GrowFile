@props(['label', 'id', 'name', 'disabled' => false, 'required' => false])

<div>
    <x-input-label :for="$id" :value="$label" class="text-lg mt-4" :required="$required"/>
    <x-text-input :id="$id" type="datetime-local" class="mt-1" wire:model.blur="{{ $name }}" :disabled="$disabled" />
    <div>
        @error($name)
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
    </div>
</div>
