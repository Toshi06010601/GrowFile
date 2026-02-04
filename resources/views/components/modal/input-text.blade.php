@props(['label', 'id', 'name', 'placeholder', 'disabled' => false, 'required' => false])

<div>
    <x-input-label :for="$id" :value="$label" class="text-lg mt-4" :required="$required" />
    <x-text-input :id="$id" type="text" class="mt-1 block w-full " :placeholder="$placeholder"
        wire:model.blur="{{ $name }}" :disabled="$disabled" />
    <div>
        @error($name)
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
    </div>
</div>
